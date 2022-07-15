<?php

namespace App\Http\Controllers;

use App\CampaignsListsSegment;
use App\Customer;
use App\EmailResponce;
use App\Library\HtmlHandler\TransformWidgets;
use App\Mail_list;
use App\SendEmail;
use App\Setting;
use App\Template;
use App\TemplateCategory;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use League\Pipeline\PipelineBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use App\Campaign;
use stdClass;

class CampaignController extends Controller
{
    public function index(){

        return view('campaigns.index');
    }

    public function listing(Request $request)
    {
        /*$customer = $request->user()->customer;

        $campaigns = $customer->campaigns()
            ->search($request->keyword)
            ->filter($request)
            ->orderBy($request->sort_order, $request->sort_direction)
            ->paginate($request->per_page);*/
        $setting=Setting::where('shop_id',Auth::id())->first();
        //        dd($setting);
        /*try{
        $url=$setting->api_end_point."/campaigns";
        $client = new Client();
        $result2 = $client->request('GET',$url . '?api_token='.$setting->api_token,[
            'verify' => false]);
        $json = $result2->getBody();
        $campaigns = json_decode($json, False);
        }catch (\Exception $exception){
            $campaigns=array();
        }*/
        $campaigns=Campaign::where('shop_id',Auth::id())->get();
        if($campaigns==null || count($campaigns)==0){$campaigns=array();}

//        dd($campaigns);
        return view('campaigns._list', [
            'campaigns' => $campaigns,
        ]);
    }
    public function overview($id)
    {
        $campaign = Campaign::findByUid($id);

        $bounced_email=EmailResponce::where(['campaign_id'=>$campaign->id])->whereIN('event',['bounce','dropped','deferred','failed'])->count();
        $open_email=EmailResponce::where(['campaign_id'=>$campaign->id,'event'=>'open'])->count();
        $click_email=EmailResponce::where(['campaign_id'=>$campaign->id,'event'=>'click'])->count();
        $unsubscribe_email=EmailResponce::where(['campaign_id'=>$campaign->id,'event'=>'unsubscribe'])->count();
        if(isset($campaign->defaultMailList->has_subscriber)) {


            $statistics = new stdClass();
            $statistics->subscriber_count = count($campaign->defaultMailList->has_subscriber);
            $statistics->open_count = $open_email;
            $statistics->click_count = $click_email;
            $statistics->abuse_feedback_count = 0;
            $statistics->bounce_count = $bounced_email;
            $statistics->unsubscribe_count = $unsubscribe_email;
//        dd($statistics);
            return view('campaigns.overview', [
                'campaign' => $campaign,
                'statistics' => $statistics,

            ]);
        }else{
            return back()->with('alert-error',"No List is assign to this campaign Or Your List was deleted.Please Create new campaign");
         }
    }
    public function startCampaign(){
        $curent_date= Carbon::now()->format("Y-m-d H:i:s");

        $campaigns=Campaign::where('status','queued')
            ->where('run_at','<=',$curent_date)
            ->get();
//        dd($campaigns);

        foreach ($campaigns as $campaign){
            $emails=EmailResponce::where([
                'campaign_id'=>$campaign->id,
                'event'=>'pending'
            ])->limit(10)->get();
            $emails1= EmailResponce::where([
                'campaign_id'=>$campaign->id,
                'event'=>'pending'
            ])->limit(10)->update(['event'=>"inprogress"]);
            $inprogress_emails= EmailResponce::where([
                'campaign_id'=>$campaign->id,
                'event'=>'inprogress'
            ])->count();

            if($campaign->type=="regular"){
//                $template=$campaign->template->content;
                $template = $campaign->prepareEmail();

                $new_link=env('APP_URL').'/assets/';
                $template = str_replace("/assets/", $new_link, $template);

//                $template=$this->getHtmlContent($get_temptale);
                // build the message from campaign information

            }else{
                $template="";
            }
//            dd($template);
            $data = [
                "template" => $template,
                "campaign_id" => $campaign->id,
                "campaign_name" => $campaign->name,
                "subject" => $campaign->subject,
//                "from_email" => $campaign->from_email,
                "from_email" => env('MAIL_FROM_ADDRESS'),
                "from_name" => $campaign->from_name,
                "reply_to" => $campaign->reply_to,
                "type" => $campaign->type,
                "plain_text" => $campaign->plain,
//                "file" => $campaign_file,
            ];
//            dd($data);
            if(count($emails)>0){

//            $smtp = Smtp::first();
//            dd($emails);
                foreach ($emails as $email){

                    $send_to=$email->email;
                    $data['user']=$email->email;
                    $data['email_responce_id']=$email->id;
//                    dd($email);
                    SendEmail::templateApi($send_to,$data);


//                   dd($send_mail);
                }
            }
//            dd(count($emails),$inprogress_emails);
            if(count($emails) == 0 && $inprogress_emails==0 ){
//                $campaign->update(['status'=>"done"]);
                Campaign::where(['id'=>$campaign->id,])->update(['status'=>"done"]);
            }
        }
    }


    public function subscribers(Request $request)
    {
        $campaign = Campaign::findByUid($request->uid);

        $total_email=EmailResponce::where(['campaign_id'=>$campaign->id])->count();
        $send_email=EmailResponce::where(['campaign_id'=>$campaign->id])->whereIN('event',['delivered','click','deferred','open','sent','spamreport'])->count();
        $not_sent_email=EmailResponce::where(['campaign_id'=>$campaign->id])->whereIN('event',['processed','bounce','dropped','pending','inprogress','unsubscribe'])->count();
        $open_email=EmailResponce::where(['campaign_id'=>$campaign->id,'event'=>'open'])->count();
        $click_email=EmailResponce::where(['campaign_id'=>$campaign->id,'event'=>'click'])->count();
        $failed_email=EmailResponce::where(['campaign_id'=>$campaign->id])->whereIN('event',['deferred','failed'])->count();
        $unsubscribe_email=EmailResponce::where(['campaign_id'=>$campaign->id,'event'=>'unsubscribe'])->count();
        if($total_email>0){
            $send_email_per=($send_email/$total_email);
            $failed_per=($failed_email/$total_email);
            $not_sent_email_per=($not_sent_email/$total_email);
        }else{
            $send_email_per=0;
            $failed_per=0;
            $not_sent_email_per=0;
        }

//        dd($send_email);
//        $subscribers = $campaign->subscribers();
        $subscribers = null;
        $stats= new stdClass();
        $stats->email_send=$send_email;
        $stats->email_send_percent=$send_email_per;
        $stats->email_failed=$failed_email;
        $stats->email_failed_percent=$failed_per;
        $stats->email_not_send=$not_sent_email;
        $stats->email_not_send_percent=$not_sent_email_per;
        $stats->unsubscribe_email=$unsubscribe_email;

        return view('campaigns.subscribers', [
            'subscribers' => $subscribers,
            'campaign' => $campaign,
            'stats' => $stats,
            'list' => $campaign->defaultMailList,
        ]);
    }
    public function subscribersListing(Request $request)
    {
        $campaign = Campaign::findByUid($request->uid);



        // Subscribers
        $subscribers = EmailResponce::where('campaign_id',$campaign->id)->get();

        // Field information
        $fields = null;

        return view('campaigns._subscribers_list', [
            'subscribers' => $subscribers,
            'list' => $campaign->defaultMailList,
            'campaign' => $campaign,
            'fields' => $fields,
        ]);
    }

    public function templateReview(Request $request)
    {
        // Get current user
        $campaign = Campaign::findByUid($request->uid);



        return view('campaigns.template_review', [
            'campaign' => $campaign,
        ]);
    }
    public function templateReviewIframe(Request $request)
    {
        // Get current user
        $campaign = Campaign::findByUid($request->uid);



        return view('campaigns.template_review_iframe', [
            'campaign' => $campaign,
        ]);
    }
    public function overview_old($id)
    {
        $setting=Setting::where('shop_id',Auth::id())->first();
        try {
            $url = $setting->api_end_point . "/campaigns/" . $id;
            $client = new Client();
            $result2 = $client->request('GET', $url . '?api_token=' . $setting->api_token, [
                'verify' => false]);
            $json = $result2->getBody();
            $campaign = json_decode($json, False);
            $campaign_d=$campaign->campaign;
            $statistics=$campaign->statistics;
        }catch (\Exception $exception){
            $campaign_d=null;
            $statistics=null;
        }

        dd($statistics);
        return view('campaigns.overview_old', [
            'campaign' => $campaign_d,
            'statistics' => $statistics,
        ]);
    }
    public function pauseCampaign($id)
    {

        $campaign_id = $id;
        $setting=Setting::where('shop_id',Auth::id())->first();
        try{
        $url = $setting->api_end_point . "/campaigns/" . $campaign_id . '/pause';
        $client = new Client();
        $result2 = $client->request('GET', $url . '?api_token=' . $setting->api_token, [
            'verify' => false]);
        $json = $result2->getBody();
        $campaign = json_decode($json, False);
//            dd($campaign);

        }catch (\Exception $exception){
            return back()->with('alert-error','Something went wrong!');

        }
        return back()->with('alert-success','Campaign pause Successfully!');
    }

    public function quickView(Request $request){
        $id = $request->uid;
        $setting=Setting::where('shop_id',Auth::id())->first();
        $url=$setting->api_end_point."/campaigns/".$id;
        $client = new Client();
        $result2 = $client->request('GET',$url . '?api_token='.$setting->api_token,[
            'verify' => false]);
        $json = $result2->getBody();
        $campaign = json_decode($json, False);

        return view('campaigns._quick_view', [
            'campaign' => $campaign->campaign,
            'statistics' => $campaign->statistics,
        ]);
    }



    public function selecttype(){



        return view('campaigns.select_type');
    }



    public function create(Request $request){

        // $customer = $request->user()->customer;

        $user = Auth::user();
        // $campaign = new Campaign([
        //     'track_open' => true,
        //     'track_click' => true,
        //     'sign_dkim' => true,
        // ]);


           // authorize
        //    if (\Gate::denies('create', $campaign)) {
        //     return $this->noMoreItem();
        // }
            $campaign=new Campaign;
        $campaign->name = trans('messages.untitled');
        $campaign->shop_id = $user->id;
         $campaign->status = Campaign::STATUS_NEW;
//        $campaign->status ='new';
        $campaign->type = $request->type;
        $campaign->save();

        return redirect()->action('CampaignController@recipients', ['uid' => $campaign->uid]);
    }
    public function edit($id)
    {
        $campaign = Campaign::findByUid($id);


        // Check step and redirect
        if ($campaign->step() == 0) {
            return redirect()->action('CampaignController@recipients', ['uid' => $campaign->uid]);
        } elseif ($campaign->step() == 1) {
            return redirect()->action('CampaignController@setup', ['uid' => $campaign->uid]);
        } elseif ($campaign->step() == 2) {
            return redirect()->action('CampaignController@template', ['uid' => $campaign->uid]);
        } elseif ($campaign->step() == 3) {
            return redirect()->action('CampaignController@schedule', ['uid' => $campaign->uid]);
        } elseif ($campaign->step() >= 4) {
            return redirect()->action('CampaignController@confirm', ['uid' => $campaign->uid]);
        }
    }
    public function  recipients(Request $request){

        $campaign = Campaign::where('uid',$request->uid)->first();


        $user = Auth::user();

        if ($request->isMethod('post')) {
            // Check validation
//            $campaign->saveRecipients($request->all());
            $data = [];
            foreach ($request->lists_segments as $lists_segments_group) {
//                dd($lists_segments_group['mail_list_uid']);

                    $data[] = [
                        'campaign_id' => $campaign->id,
                        'mail_list_id' => $lists_segments_group['mail_list_uid'],
                    ];

            }

            // Empty old data
            CampaignsListsSegment::where('campaign_id',$campaign->id)->delete();

            // Insert Data
            CampaignsListsSegment::insert($data);

            // Save campaign with default list id
            $campaign = Campaign::find($campaign->id);
            $campaign->default_mail_list_id = $request->lists_segments[0]['mail_list_uid'];
            $campaign->save();
            $mail_list=Mail_list::where('id',$campaign->default_mail_list_id)->first();
//            dd($mail_list);
           $email_res= EmailResponce::where('campaign_id',$campaign->id)->first();
           if($email_res !=null){
               EmailResponce::where('campaign_id',$campaign->id)->delete();
           }
            foreach ($mail_list->has_subscriber as $customer){
                $email_res=new EmailResponce();
                $email_res->campaign_id=$campaign->id;
                $email_res->mail_list_id=$campaign->default_mail_list_id;
                $email_res->email=$customer->email;
                $email_res->event='pending';
                $email_res->save();
            }


            // redirect to the next step
            return redirect()->action('CampaignController@setup', ['uid' => $campaign->uid]);
        }
      $show_list=Mail_list::withCount('has_subscriber')->where('shop_id',$user->id)->get();
//      dd($show_list);
      return view('campaigns.recipients',compact('campaign','show_list'));
    }


    public function setup(Request $request)
    {
        $customer = $request->user();
        $campaign = Campaign::where('uid',$request->uid)->first();

//dd($request->all());

        $campaign->from_name = !empty($campaign->from_name) ? $campaign->from_name : $campaign->defaultMailList->from_name;
        $campaign->from_email = !empty($campaign->from_email) ? $campaign->from_email : $campaign->defaultMailList->from_email;
        $campaign->subject = !empty($campaign->subject) ? $campaign->subject : $campaign->defaultMailList->default_subject;

        // validate and save posted data
        if ($request->isMethod('post')) {
            // Fill values
            $campaign->name = $request->name;
            $campaign->subject = $request->subject;
            $campaign->from_name = $request->from_name;
            $campaign->from_email = $request->from_email;
            $campaign->reply_to = $request->reply_to;
            $campaign->save();
            $email_res= EmailResponce::where('campaign_id',$campaign->id)->update([
                'subject'=> $campaign->subject,
                'from_name'=> $campaign->from_name,
                'from_email'=> $campaign->from_email,
                'reply_to'=> $campaign->reply_to,
            ]);


            // Log
//            $campaign->log('created', $customer);

            return redirect()->action('CampaignController@template', ['uid' => $campaign->uid]);
        }

//        $rules = $campaign->rules();

        return view('campaigns.setup', [
            'campaign' => $campaign
//            'rules' => $campaign->rules(),
        ]);
    }


    public function template(Request $request){

        $campaign = Campaign::findByUid($request->uid);

//dd($uid);

        if ($campaign->type == 'plain-text') {
            return redirect()->action('CampaignController@plain', ['uid' => $campaign->uid]);
        }

        // check if campagin does not have template
        if (!$campaign->template) {
            return redirect()->action('CampaignController@templateCreate', ['uid' => $campaign->uid]);
        }

        return view('campaigns.template.index', [
            'campaign' => $campaign,
//            'spamscore' => Setting::isYes('spamassassin.enabled'),
        ]);
    }
    /**
     * Create template.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function templateCreate(Request $request)
    {
        $campaign = Campaign::findByUid($request->uid);



        return view('campaigns.template.create', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * Create template from layout.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function templateLayout(Request $request)
    {
        $campaign = Campaign::findByUid($request->uid);



        if ($request->isMethod('post')) {
            $template = Template::findByUid($request->template);
            $campaign->setTemplate($template);

            // return redirect()->action('CampaignController@templateEdit', $campaign->uid);
            return response()->json([
                'status' => 'success',
                'message' => trans('messages.campaign.theme.selected'),
                'url' => action('CampaignController@templateBuilderSelect', $campaign->uid),
            ]);
        }

        // default tab
        if ($request->from != 'mine' && !$request->category_uid) {
            $request->category_uid = TemplateCategory::first()->uid;
        }

        return view('campaigns.template.layout', [
            'campaign' => $campaign
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function templateLayoutList(Request $request)
    {
        $campaign = Campaign::findByUid($request->uid);

        // from
        if ($request->from == 'mine') {
            $templates = $request->user()->templates();
        } elseif ($request->from == 'gallery') {
            $templates = Template::shared();
        } else {
            $templates = Template::shared()
                ->orWhere('customer_id', '=', $request->user()->id);
        }

        $templates = $templates->notAssociated()->search($request->keyword);

        // category id
        if ($request->category_uid) {
            $templates = $templates->categoryUid($request->category_uid);
        }

        $templates = $templates->orderBy($request->sort_order, $request->sort_direction)
            ->paginate($request->per_page);

        return view('campaigns.template.layoutList', [
            'campaign' => $campaign,
            'templates' => $templates,
        ]);
    }

    /**
     * Select builder for editing template.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function templateBuilderSelect(Request $request, $uid)
    {
        $campaign = Campaign::findByUid($uid);



        return view('campaigns.template.templateBuilderSelect', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * Edit campaign template.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function templateEdit(Request $request)
    {
        $campaign = Campaign::findByUid($request->uid);


        // save campaign html
        if ($request->isMethod('post')) {
            $rules = array(
                'content' => 'required',
            );

            /*$this->validate($request, $rules);

            // template extra validation by plan (unsubscribe URL for example)
            // UGLY code here, @todo: find a good place to handle this type of validation
            $plan = $request->user()->customer->activeSubscription()->plan;
            if ($plan->getOption('unsubscribe_url_required') == 'yes' && Setting::isYes('campaign.enforce_unsubscribe_url_check')) {
                if (strpos($request->content, '{UNSUBSCRIBE_URL}') === false) {
                    return response()->json(['message' => trans('messages.template.validation.unsubscribe_url_required')], 400);
                }
            }*/

            $campaign->setTemplateContent($request->content);
            $campaign->save();

            // update plain
            $campaign->updatePlainFromHtml();

            return response()->json([
                'status' => 'success',
            ]);
        }

        return view('campaigns.template.edit', [
            'campaign' => $campaign,
            'list' => $campaign->defaultMailList,
            'templates' => $request->user()->getBuilderTemplates(),
        ]);
    }

    /**
     * Campaign html content.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function templateContent(Request $request)
    {
        $campaign = Campaign::findByUid($request->uid);



        return view('campaigns.template.content', [
            'content' => $campaign->template->content,
        ]);
    }

    /**
     * Upload template.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function templateUpload(Request $request)
    {
        $campaign = Campaign::findByUid($request->uid);


        // validate and save posted data
        if ($request->isMethod('post')) {
            $campaign->uploadTemplate($request);

            // return redirect()->action('CampaignController@template', $campaign->uid);
            return response()->json([
                'status' => 'success',
                'message' => trans('messages.campaign.template.uploaded'),
                'url' => action('CampaignController@templateBuilderSelect', $campaign->uid),
            ]);
        }

        return view('campaigns.template.upload', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * Choose an existed template.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function plain(Request $request)
    {
        $user = $request->user();
        $campaign = Campaign::findByUid($request->uid);



        // validate and save posted data
        if ($request->isMethod('post')) {
            // Check validation
            $this->validate($request, ['plain' => 'required']);

            // save campaign plain text
            $campaign->plain = $request->plain;
            $campaign->save();

            return redirect()->action('CampaignController@schedule', ['uid' => $campaign->uid]);
        }

        return view('campaigns.plain', [
            'campaign' => $campaign,
        ]);
    }
    public function preview($id)
    {
        $campaign = Campaign::findByUid($id);
        $previousURL = url()->previous();
        cookie()->queue(cookie()->forever('custom_url', $previousURL));
//dd(1);
        return view('campaigns.preview', [
            'campaign' => $campaign,
        ]);
    }
    public function previewContent(Request $request,$uid)
    {
//        dd($uid);
        $campaign = Campaign::findByUid($uid);

//        $subscriber = Subscriber::findByUid($request->subscriber_uid);
//        echo $campaign->getHtmlContent($subscriber);
        echo $campaign->template->getPreviewContent();
    }

    /**
     * Template preview iframe.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function templateIframe(Request $request)
    {
        $user = $request->user();
        $campaign = Campaign::findByUid($request->uid);



        return view('campaigns.preview', [
            'campaign' => $campaign,
        ]);
    }
    public function builderClassic(Request $request, $uid)
    {
        // Generate info
        $campaign = Campaign::findByUid($uid);


        // validate and save posted data
        if ($request->isMethod('post')) {
            $rules = array(
                'html' => 'required',
            );

            // make validator
//            $validator = \Validator::make($request->all(), $rules);

            // redirect if fails
//            if ($validator->fails()) {
//                // faled
//                return response()->json($validator->errors(), 400);
//            }

            // UGLY CODE here, @todo: find a better place to house this type of validation
            /*$plan = $request->user()->activeSubscription()->plan;
            if ($plan->getOption('unsubscribe_url_required') == 'yes' && Setting::isYes('campaign.enforce_unsubscribe_url_check')) {
                if (strpos($request->html, '{UNSUBSCRIBE_URL}') === false) {
                    return response()->json(['message' => trans('messages.template.validation.unsubscribe_url_required')], 400);
                }
            }*/

            // Save template
            $campaign->setTemplateContent($request->html);
            $campaign->preheader = $request->preheader;
            $campaign->save();

            // update plain
            $campaign->updatePlainFromHtml();

            // success
            return response()->json([
                'status' => 'success',
                'message' => trans('messages.template.updated'),
            ], 201);
        }

        return view('campaigns.builderClassic', [
            'campaign' => $campaign,
        ]);
    }

    public function schedule(Request $request)
    {
        $campaign = Campaign::findByUid($request->uid);
//        dd($campaign);
        // check step
        if ($campaign->step() < 3) {
            return redirect()->action('CampaignController@template', ['uid' => $campaign->uid]);
        }



        $delivery_date = isset($campaign->run_at) && $campaign->run_at != '0000-00-00 00:00:00' ? Carbon::parse($campaign->run_at)->format('Y-m-d') : Carbon::now()->format('Y-m-d');
        $delivery_time = isset($campaign->run_at) && $campaign->run_at != '0000-00-00 00:00:00' ? Carbon::parse($campaign->run_at)->format('H:i') : Carbon::now()->format('H:i');

        $rules = array(
            'delivery_date' => 'required',
            'delivery_time' => 'required',
        );

        // Get old post values
        /*if (null !== $request->old()) {
            $campaign->fill($request->old());
        }*/

        // validate and save posted data
        if ($request->isMethod('post')) {
            // Check validation
            // $this->validate($request, $rules);

            //// Save campaign
            $time = \App\Library\Tool::systemTimeFromString($request->delivery_date.' '.$request->delivery_time);
            $campaign->run_at = $time;
            $campaign->save();

            return redirect()->action('CampaignController@confirm', ['uid' => $campaign->uid]);
        }

        return view('campaigns.schedule', [
            'campaign' => $campaign,
            'rules' => $rules,
            'delivery_date' => $delivery_date,
            'delivery_time' => $delivery_time,
        ]);
    }



    public function confirm(Request $request)
    {
        $customer = $request->user();
        $campaign = Campaign::findByUid($request->uid);

        // check step
        if ($campaign->step() < 4) {
            return redirect()->action('CampaignController@schedule', ['uid' => $campaign->uid]);
        }



//        try {
//            $score = $campaign->score();
//        } catch (\Exception $e) {
            $score = null;
//        }

        // validate and save posted data
        if ($request->isMethod('post') && $campaign->step() >= 5) {
            // UGLY CODE
            $campaign->status = Campaign::STATUS_QUEUED;
            $campaign->save();

            return redirect()->action('CampaignController@index');
        }

        return view('campaigns.confirm', [
            'campaign' => $campaign,
            'score' => $score,
        ]);
    }



}
