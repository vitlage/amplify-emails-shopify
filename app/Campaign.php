<?php

namespace App;

use App\Library\Traits\HasTemplate;
use App\Library\Traits\HasUid;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasUid;
    use HasTemplate;

// Campaign status
    public const STATUS_NEW = 'new';
    public const STATUS_QUEUING = 'queuing'; // equiv. to 'queue'
    public const STATUS_QUEUED = 'queued'; // equiv. to 'queue'
    public const STATUS_SENDING = 'sending';
    public const STATUS_ERROR = 'error';
    public const STATUS_DONE = 'done';
    public const STATUS_PAUSED = 'paused';

    // Campaign types
    public const TYPE_REGULAR = 'regular';
    public const TYPE_PLAIN_TEXT = 'plain-text';

    // 4 types of delivery status for a given contact
    public const DELIVERY_STATUS_FAILED = 'failed';
    public const DELIVERY_STATUS_SENT = 'sent';
    public const DELIVERY_STATUS_NEW = 'new';
    public const DELIVERY_STATUS_SKIPPED = 'skipped';
    public const DELIVERY_STATUS_BOUNCED = 'bounced';
    public const DELIVERY_STATUS_FEEDBACK = 'feedback';

     protected $fillable = [
        'name',
        'subject', 'from_name', 'from_email',
        'reply_to', 'track_open',
        'track_click', 'sign_dkim', 'track_fbl',
        'html', 'plain', 'template_source',
        'tracking_domain_id', 'use_default_sending_server_from_email',
    ];

     public static function types()
     {
         return [
             'regular' => [
                 'icon' => 'attach_email',
             ],
             'plain-text' => [
                 'icon' => 'wysiwyg',
             ],
         ];
     }

    public function template()
    {
        return $this->belongsTo('App\Template');
    }
    public function user()
    {
        return $this->belongsTo('App\User','shop_id','id');
    }

    public function setTemplate($template)
    {
        $campaignTemplate = $template->copy([
            'name' => trans('messages.campaign.template_name', ['name' => $this->name]),
            'customer_id' => $this->customer_id,
        ]);

        // remove exist template
        if ($this->template) {
            $this->template->deleteAndCleanup();
        }

        $this->template_id = $campaignTemplate->id;
        $this->save();
        $this->refresh();
        $this->updatePlainFromHtml();
//        $this->updateLinks();
    }

    public function updatePlainFromHtml()
    {
        if (!$this->plain) {
            $this->plain = preg_replace('/\s+/', ' ', preg_replace('/\r\n/', ' ', strip_tags($this->getTemplateContent())));
            $this->save();
        }
    }
    public function updateLinks()
    {
        if ($this->type == self::TYPE_PLAIN_TEXT) {
            return;
        }

        $this->campaignLinks()->delete();

        foreach ($this->getUrls() as $url) {
            // Campaign link
            if ($this->campaignLinks()->where('url', '=', $url)->count() == 0) {
                $cl = new CampaignLink();
                $cl->campaign_id = $this->id;
                $cl->url = $url;
                $cl->save();
            }
        }
    }
    /**
     * Set template content.
     */
    public function setTemplateContent($content, $callback = null)
    {
        if (!$this->template) {
            throw new \Exception('Cannot set content: campaign/email does not have template!');
        }

        $template = $this->template;
        $template->content = $content;
        $template->save();
        if (!is_null($callback)) {
            $callback($this);
        }
    }

    /**
     * Get template content.
     */
    public function getTemplateContent()
    {
        if (!$this->template) {
            throw new \Exception('Cannot get content: campaign/email does not have template!');
        }

        return $this->template->content;
    }
    public function defaultMailList()
    {
        return $this->belongsTo('App\Mail_list', 'default_mail_list_id','id');
    }
     public function step()
    {
        $step = 0;

        // Step 1
        if (is_object($this->defaultMailList)) {
            $step = 1;
        } else {
            return $step;
        }

        // Step 2
        if (!empty($this->name) && !empty($this->subject) && !empty($this->from_name)
                && !empty($this->from_email) && !empty($this->reply_to)) {
            $step = 2;
        } else {
            return $step;
        }

        // Step 3
        if (($this->template || $this->type == 'plain-text') && !empty($this->plain)) {
            $step = 3;
        } else {
            return $step;
        }

        // Step 4
        if (isset($this->run_at) && $this->run_at != '0000-00-00 00:00:00') {
            $step = 4;
        } else {
            return $step;
        }

        // Step 5
        // @todo: consider removing this check!
        if (is_object($this->subscribers([]))) {
            $step = 5;
        } else {
            return $step;
        }

        return $step;
    }

public function subscribers($params = [])
{
    return $this->defaultMailList->has_subscriber;
}


    public function listsSegments()
    {


        return $this->hasMany('App\CampaignsListsSegment');
    }

    public function fillRecipients($params = [])
    {
        if (isset($params['lists_segments'])) {
            foreach ($params['lists_segments'] as $key => $param) {
                $mail_list = null;

                if (!empty($param['mail_list_uid'])) {
                    $mail_list = Mail_list::findByUid($param['mail_list_uid']);

                    // default mail list id
                    if (isset($param['is_default']) && $param['is_default'] == 'true') {
                        $this->default_mail_list_id = $mail_list->id;
                    }
                }

                if (!empty($param['segment_uids'])) {
                    foreach ($param['segment_uids'] as $segment_uid) {
                        $segment = Segment::findByUid($segment_uid);

                        $lists_segment = new CampaignsListsSegment();
                        $lists_segment->campaign_id = $this->id;
                        if (is_object($mail_list)) {
                            $lists_segment->mail_list_id = $mail_list->id;
                        }
                        $lists_segment->segment_id = $segment->id;
                        $this->listsSegments->push($lists_segment);
                    }
                } else {
                    $lists_segment = new CampaignsListsSegment();
                    $lists_segment->campaign_id = $this->id;
                    if (is_object($mail_list)) {
                        $lists_segment->mail_list_id = $mail_list->id;
                    }
                    $this->listsSegments->push($lists_segment);
                }
            }
        }
    }

    public function saveRecipients($params = [])
    {
        dd($params);
        // Empty current data
        $this->listsSegments = collect([]);
        // Fill params
        $this->fillRecipients($params);

        $lists_segments_groups = $this->getListsSegmentsGroups();

        $data = [];
        foreach ($lists_segments_groups as $lists_segments_group) {
            if (!empty($lists_segments_group['segment_uids'])) {
                foreach ($lists_segments_group['segment_uids'] as $segment_uid) {
                    $segment = Segment::findByUid($segment_uid);
                    $data[] = [
                        'campaign_id' => $this->id,
                        'mail_list_id' => $lists_segments_group['list']->id,
                        'segment_id' => $segment->id,
                    ];
                }
            } else {
                $data[] = [
                    'campaign_id' => $this->id,
                    'mail_list_id' => $lists_segments_group['list']->id,
                    'segment_id' => null,
                ];
            }
        }

        // Empty old data
        $this->listsSegments()->delete();

        // Insert Data
        CampaignsListsSegment::insert($data);

        // Save campaign with default list id
        $campaign = Campaign::find($this->id);
        $campaign->default_mail_list_id = $this->default_mail_list_id;
        $campaign->save();
    }

    public function getListsSegments()
    {


        $lists_segments = $this->listsSegments;
        if ($lists_segments->isEmpty()) {

            $lists_segment = new CampaignsListsSegment();
            $lists_segment->campaign_id = $this->id;
            $lists_segment->is_default = true;

            $lists_segments->push($lists_segment);
        }
//        dd($lists_segments);

        return $lists_segments;
    }



    public function getListsSegmentsGroups()
    {


        $lists_segments = $this->getListsSegments();

//dd($lists_segments);
        $groups = [];

        foreach ($lists_segments as $lists_segment) {



            if (!isset($groups[$lists_segment->mail_list_id])) {


                $groups[$lists_segment->mail_list_id] = [];
                $groups[$lists_segment->mail_list_id]['list'] = $lists_segment->mailList;
//                dd($this->default_mail_list_id);

                if ($this->default_mail_list_id == $lists_segment->mail_list_id) {
                    $groups[$lists_segment->mail_list_id]['is_default'] = true;
                } else {
                    $groups[$lists_segment->mail_list_id]['is_default'] = false;
                }
                $groups[$lists_segment->mail_list_id]['segment_uids'] = [];
//                dd($groups);
            }
            if (is_object($lists_segment->segment) && !in_array($lists_segment->segment->uid, $groups[$lists_segment->mail_list_id]['segment_uids'])) {
                $groups[$lists_segment->mail_list_id]['segment_uids'][] = $lists_segment->segment->uid;
//                dd(2);

            }
        }
//        dd(3);

        return $groups;
    }
    public function getAttachmentPath($path = null)
    {
        return $this->user->getAttachmentsPath($path);
    }
    public function getAttachments()
    {
        $atts = [];
        $path_campaign = $this->getAttachmentPath();

        if (!is_dir($path_campaign)) {
            return $atts;
        }

        $ffs = scandir($path_campaign);

        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);

        // prevent empty ordered elements
        if (count($ffs) < 1) {
            return $atts;
        }

        foreach ($ffs as $k => $ff) {
            $atts[] = $ff;
        }

        return $atts;
    }

}
