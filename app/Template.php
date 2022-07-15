<?php

namespace App;

use App\Library\StringHelper;
use App\Library\Tool;
use File;
use App\Library\Traits\HasUid;
use App\Library\HtmlHandler\TransformWidgets;
use Illuminate\Database\Eloquent\Model;
use League\Pipeline\PipelineBuilder;
use function App\Helpers\generatePublicPath;
use function App\Helpers\getAppHost;

class Template extends Model
{
    use HasUid;
    public const BUILDER_ENABLED = true;
    public const BUILDER_DISABLED = false;
    public static $itemsPerPage = 25;

    protected $fillable = [
        'uid', 'name', 'content', 'builder', 'is_default', 'theme'
    ];
     public function customer()
     {
         return $this->belongsTo('App\User','customer_id','id');
     }
    public function categories()
    {
        return $this->belongsToMany('App\TemplateCategory', 'templates_categories', 'template_id', 'category_id');
    }
    public function changeName($name)
    {
        $validator = \Validator::make(['name' => $name], [
            'name' => 'required',
        ]);

        // redirect if fails
        if ($validator->fails()) {
            return $validator;
        }

        $this->name = $name;
        $this->save();

        return $validator;
    }
    public function deleteAndCleanup()
    {
        $this->clearStorage();
        $this->delete();
    }
    public function clearStorage()
    {
        Tool::xdelete($this->getStoragePath());
    }
    public function scopeSearch($query, $keyword)
    {
        // Keyword
        if (!empty($keyword)) {
            $query = $query->where('name', 'like', '%'.trim($keyword).'%');
        }
    }
    public function scopeCategoryUid($query, $uid)
    {
        $category =TemplateCategory::where('uid', '=', $uid)->first();
        // Category
        if ($category) {
            $query = $query->whereHas('categories', function ($q) use ($category) {
                $q->whereIn('template_categories.id', [$category->id]);
            });
        }
    }
    // Templates that are not associated to any email or campaign
    public function scopeNotAssociated($query)
    {
        /*$query->whereNotIn('id', function ($q) {
            $q->select('template_id')->from('emails')->whereNotNull('template_id');
        });*/

        $query->whereNotIn('id', function ($q) {
            $q->select('template_id')->from('campaigns')->whereNotNull('template_id');
        });
    }
    public function scopeCustom($query)
    {
        $query = $query->whereNotNull('customer_id');
    }
    public static function scopeShared($query)
    {
        $query = $query->whereNull('customer_id');
    }


    public function getThumbName()
    {
        // find index
        $names = array('thumbnail.svg', 'thumbnail.png', 'thumbnail.jpg', 'thumb.svg', 'thumb.png', 'thumb.jpg');
        foreach ($names as $name) {
            $path = $this->getStoragePath($name);
            if (file_exists($path)) {
                return $name;
            }
        }

        return;
    }
    public function getThumbUrl()
    {
        if (is_null($this->uid)) {
            throw new Exception('Cannot getThumbUrl(), template does not have a UID, cannot transform content');
        }
//        dd(filemtime($this->getStoragePath($this->getThumbName())));
        if ($this->getThumbName()) {
            return generatePublicPath($this->getStoragePath($this->getThumbName())) . '?' . filemtime($this->getStoragePath($this->getThumbName()));
        } else {
            return url('images/placeholder.jpg');
        }
    }
    public function getPreviewContent()
    {
        // Bind subscriber/message/server information to email content
        $pipeline = new PipelineBuilder();
        $pipeline->add(new TransformWidgets($this));

        // Actually push HTML to pipeline for processing
        $html = $pipeline->build()->process($this->content);

        // Return subscriber's bound html
        return $html;
    }

    public function getStoragePath($path = '/')
    {
//        if ($this->customer) {
//            // storage/app/users/{uid}/templates
//            $base = $this->customer->getTemplatesPath($this->uid);
//        } else {
            // storage/app/templates/templates
            // IMPORTANT: templates are created from migration without associating with an admin
            $base = $this->getSystemStoragePath($this->uid);
//        }

        if (!\File::exists($base)) {
            \File::makeDirectory($base, 0777, true, true);
        }

        return join_paths($base, $path);
    }

    private function getSystemStoragePath($path = null)
    {
        $base = storage_path('app/templates/');

        if (!\File::exists($base)) {
            \File::makeDirectory($base, 0777, true, true);
        }

        return join_paths($base, $path);
    }
    public function copy($attributes = [])
    {
        $copy = new self();

        // UID and Customer ID must be present first, in order to create directory and to transformURL
        $copy->generateUid();
        // IMPORTANT
        // copy a shared template to customer --> then customer_id must be present
        // copy a customer template to customer --> either present or null is ok
        // copy a shared template to another shared template --> then customer_id must be empty (of course)
        $copy->customer_id = isset($attributes['customer_id']) ? $attributes['customer_id'] : $this->customer_id;

        // Copy content
        // The two steps below are important
        // First: convert $this' asset base URL to relative URL (for assets)
        // Then: transform relative URLS for $copy
        $copy->content = $this->getContentWithUntransformedAssetsUrls();
        $copy->transformAssetsUrls(); // important

        // copy theme
        $copy->theme = $this->theme;

        // Copy flags
        $copy->builder = $this->builder;
        $copy->is_default = false; // no longer default

        // Overwrite attributes :name
        $copy->name = isset($attributes['name']) ? $attributes['name'] : $this->name;

        // Then save, generate UID, created_at, updated_at
        $copy->save();

        // Copy directory
        \App\Helpers\pcopy($this->getStoragePath(), $copy->getStoragePath());

        // Important: save before adding categories
        foreach ($this->categories as $category) {
            $copy->addCategory($category);
        }

        // return
        return $copy;
    }

    public function getContentWithUntransformedAssetsUrls($untransformUserAssets = false, $processUserAssetCallback = null)
    {
        // Clean up subdirectory, leaving the url as '/assets/path/file.jpg' only
        $subdirectory = \App\Helpers\getAppSubdirectory();
        if ($subdirectory) {
            // Make sure $subdirectory looks like: '/subdir'
            // i.e. with a leading slash but without trailing one
            $subdirectory = rtrim(join_paths('/', $subdirectory), '/');
        }

        // Replace #1
        return StringHelper::transformUrls($this->content, function ($url) use ($subdirectory, $untransformUserAssets, $processUserAssetCallback) {
            if (parse_url($url, PHP_URL_HOST) === false) {
                // if url is invalid
                return $url;
            }

            if (!is_null(parse_url($url, PHP_URL_HOST))) {
                // url is with a host like "http://" or "//"
                return $url;
            }

            if (strpos($url, 'data:') === 0) {
                // base64 image. Like: "data:image/png;base64,iVBOR"
                return $url;
            }

            if (strpos($url, '/') !== 0) {
                // Relative path, ignore
                return $url;
            }

            if ($subdirectory) {
                // Remove subdirectory of URL, keep the leading slash '/'
                $url = str_replace($subdirectory, '', $url);
            }

            // There are two cases when we untransform a URL
            // 1. Template local assets: '/assets/'
            // 2. User library assets: '/files/'

            // preg_match('/\/assets\/(?<dirname>[^\/]+)\/(?<basename>[^\/]+)/', '/assets/dir/file.jpg', $match);
            if (strpos($url, '/assets/') === 0) {
                $assetPath = $this->getAssetFileFromUrl($url);
                $relativePath = $this->extractAssetRelativePath($assetPath);
                if ($relativePath) {
                    return $relativePath;
                } else {
                    return $url;
                }
            } elseif (strpos($url, '/files/') === 0 && $untransformUserAssets) {
                // Okie, now process /files/uid/name.jpg pattern
                list($prefix, $userUid, $basename) = array_values(array_filter(explode('/', $url)));
//                dd($userUid);
                $user = User::findByUid($userUid);
                if (is_null($user)) {
                    return $url;
                }

                $assetPath = $user->getAssetsPath($basename);

                // If file no longer exists
                if (!file_exists($assetPath)) {
                    return $url;
                }

                // Callback and return
                if (!is_null($processUserAssetCallback)) {
                    $processUserAssetCallback($assetPath, $basename); // Important: basename may be changed
                }

                // Return to replace
                return $basename;
            } else {
                return $url;
            }
        });
    }
    public function getAssetFileFromUrl($url)
    {
        // To remove query string if any like ?search=abc
        // For example
        //     parse_url('/assets/path/file.jpg?id=320943&search=', PHP_URL_PATH)
        // Returns
        //     /assets/path/file.jpg
        $url = parse_url($url, PHP_URL_PATH);

        // Clean up subdirectory, leaving the url as '/assets/path/file.jpg' only
        $subdirectory = \App\Helpers\getAppSubdirectory();
        if ($subdirectory) {
            // Make sure $subdirectory looks like '/subdir' ==> with a leading slash but without trailing one
            $subdirectory = rtrim(join_paths('/', $subdirectory), '/');

            // Remove subdirectory of URL
            $url = str_replace($subdirectory, '', $url);
        }

        // preg_match('/\/assets\/(?<dirname>[^\/]+)\/(?<basename>[^\/]+)/', '/assets/dir/file.jpg', $match);
        if (strpos($url, '/assets/') === 0) {
            list($prefix, $dirname, $basename) = array_values(array_filter(explode('/', $url)));
            $dirname = StringHelper::base64UrlDecode($dirname);
            $absPath = storage_path(join_paths($dirname, $basename));

            return $absPath;
        } else {
            return null;
        }
    }
    public function extractAssetRelativePath($absPath)
    {
        $myPath = $this->getStoragePath('/');
        if (strpos($absPath, $myPath) !== 0) {
            return null;
        }

        $relativePath = trim(str_replace($myPath, '', $absPath), '/');
        return empty($relativePath) ? null : $relativePath;
    }
    public function transformAssetsUrls()
    {
        $this->content = $this->getContentWithTransformedAssetsUrls($this->content);
    }
    public function getContentWithTransformedAssetsUrls($html, $withHost = false, Closure $urlTransform = null, TrackingDomain $domain = null)
    {
        if (!is_null($domain) && $withHost == false) {
            throw new \Exception('Passing $domain parameter while the $withHost parameter is false');
        }

        if (!is_null($urlTransform) && $withHost == false) {
            throw new \Exception('Passing $urlTransform parameter while the $withHost parameter is false');
        }

        if (is_null($this->uid)) {
            throw new \Exception('Template does not have a UID, cannot transform content');
        }

        // Replace #1
        $content = StringHelper::transformUrls($html, function ($url, $element) use ($withHost, $domain, $urlTransform) {
            if (strpos($url, '#') === 0) {
                return $url;
            }

            if (strpos($url, 'mailto:') === 0) {
                return $url;
            }

            if (parse_url($url, PHP_URL_HOST) === false) {
                // false ==> if url is invalid
                // null ==> if url does not have host information
                return $url;
            }

            if (StringHelper::isTag($url)) {
                return $url;
            }

            if (!is_null(parse_url($url, PHP_URL_HOST))) {
                // url is with a host like "http://" or "//"
                if (!is_null($urlTransform)) {
                    $url = $urlTransform($url, $element);
                }

                if ($domain) {
                    $url = $domain->buildTrackingUrl($url);
                }

                return $url;
            }

            if (strpos($url, '/') === 0) {
                // absolute url with leading slash (/) like "/hello/world"

                $urlWithHost = join_url(getAppHost(), $url);
                if (!is_null($urlTransform)) {
                    $urlWithHost = $urlTransform($urlWithHost, $element);
                }

                if ($domain) {
                    return $domain->buildTrackingUrl($urlWithHost, $element);
                } elseif ($withHost) {
                    return $urlWithHost;
                } else {
                    return $url;
                }
            } elseif (strpos($url, 'data:') === 0) {
                // base64 image. Like: "data:image/png;base64,iVBOR"
                return $url;
            } else {
                // URL is a relative path like "images/banner.jpg"
                // Transform relative URLs to PUBLIC ABSOLUTE URLs with leading slash /
                $url = \App\Helpers\generatePublicPath(
                    $this->getStoragePath($url),
                    $absolute = ($withHost) ? true : false
                );

                if (!is_null($urlTransform)) {
                    $url = $urlTransform($url, $element);
                }

                if ($domain) {
                    return $domain->buildTrackingUrl($url);
                } else {
                    return $url;
                }
            }
        });

        return $content;
    }
    public function buildTrackingUrl(string $url)
    {
        if (!parse_url($url, PHP_URL_HOST)) {
            throw new \Exception('Cannot build tracking URL with "'.$url.'", a valid URL is required (with leading http:// or https:// or //');
        }

        // Already a tracking domain
        if (strpos($url, $this->getUrl()) === 0) {
            return $url;
        }

        $encodedUrl = StringHelper::base64UrlEncode($url);
        return join_url($this->getUrl(), $encodedUrl);
    }
    public function hasCategory($category)
    {
        return $this->categories()->where('template_categories.id', $category->id)->exists();
    }
    public function addCategory($category)
    {
        if (!$this->hasCategory($category)) {
            $this->categories()->attach($category->id);
        }
    }
    public function removeCategory($category)
    {
        if ($this->hasCategory($category)) {
            $this->categories()->detach($category->id);
        }
    }
    public function getUrl()
    {
        return $this->scheme.'://'.$this->name;
    }

    public function getVerificationUrl()
    {
        return $this->getUrl().route('appkey', [], false);
    }
    public static function tags($list = null)
    {
        $tags = [];

        $tags[] = ['name' => 'SUBSCRIBER_EMAIL', 'required' => false];

        // List field tags
//        dd($list);
        if (isset($list)) {
        if (isset($list->fields)) {
            foreach ($list->fields as $field) {
                if ($field->tag != 'EMAIL') {
                    $tags[] = ['name' => 'SUBSCRIBER_'.$field->tag, 'required' => false];
                }
            }
            }
        }

        $tags = array_merge($tags, [
            ['name' => 'UNSUBSCRIBE_URL', 'required' => false],
            ['name' => 'SUBSCRIBER_UID', 'required' => false],
            ['name' => 'WEB_VIEW_URL', 'required' => false],
            ['name' => 'UPDATE_PROFILE_URL', 'required' => false],
            ['name' => 'CAMPAIGN_NAME', 'required' => false],
            ['name' => 'CAMPAIGN_UID', 'required' => false],
            ['name' => 'CAMPAIGN_SUBJECT', 'required' => false],
            ['name' => 'CAMPAIGN_FROM_EMAIL', 'required' => false],
            ['name' => 'CAMPAIGN_FROM_NAME', 'required' => false],
            ['name' => 'CAMPAIGN_REPLY_TO', 'required' => false],
            ['name' => 'CURRENT_YEAR', 'required' => false],
            ['name' => 'CURRENT_MONTH', 'required' => false],
            ['name' => 'CURRENT_DAY', 'required' => false],
            ['name' => 'CONTACT_NAME', 'required' => false],
            ['name' => 'CONTACT_COUNTRY', 'required' => false],
            ['name' => 'CONTACT_STATE', 'required' => false],
            ['name' => 'CONTACT_CITY', 'required' => false],
            ['name' => 'CONTACT_ADDRESS_1', 'required' => false],
            ['name' => 'CONTACT_ADDRESS_2', 'required' => false],
            ['name' => 'CONTACT_PHONE', 'required' => false],
            ['name' => 'CONTACT_URL', 'required' => false],
            ['name' => 'CONTACT_EMAIL', 'required' => false],
            ['name' => 'LIST_NAME', 'required' => false],
            ['name' => 'LIST_SUBJECT', 'required' => false],
            ['name' => 'LIST_FROM_NAME', 'required' => false],
            ['name' => 'LIST_FROM_EMAIL', 'required' => false],
        ]);

        return $tags;
    }
    public static function builderTags($list = null)
    {
        $tags = self::tags($list);

        $result = [];

        if (true) {

            // Unsubscribe link
            $result[] = [
                'type' => 'label',
                'text' => '<a href="{UNSUBSCRIBE_URL}">' . trans('messages.editor.unsubscribe_text') . '</a>',
                'tag' => '{UNSUBSCRIBE_LINK}',
                'required' => true,
            ];

            // web view link
            $result[] = [
                'type' => 'label',
                'text' => '<a href="{WEB_VIEW_URL}">' . trans('messages.editor.click_view_web_version') . '</a>',
                'tag' => '{WEB_VIEW_LINK}',
                'required' => true,
            ];
        }

        foreach ($tags as $tag) {
            $result[] = [
                'type' => 'label',
                'text' => '{'.$tag['name'].'}',
                'tag' => '{'.$tag['name'].'}',
                'required' => true,
            ];
        }

        return $result;
    }
    public function updateContent($content)
    {
        $this->content = $content;
        $this->save();
    }
    public function urlTagsDropdown()
    {
        return [
            ['value' => '{UNSUBSCRIBE_URL}', 'text' => trans('messages.editor.unsubscribe_text')],
            ['value' => '{UPDATE_PROFILE_URL}', 'text' => trans('messages.editor.update_profile_text')],
            ['value' => '{WEB_VIEW_URL}', 'text' => trans('messages.editor.click_view_web_version')],
        ];
    }
    public function createTmpZip()
    {
        $tmpDir = storage_path("tmp/template-" . $this->uid);
        $tmpZipFile = "{$tmpDir}.zip";
        $indexFile = join_paths($tmpDir, 'index.html');

        // Copy template folder to tmp place
        \App\Helpers\pcopy($this->getStoragePath(), $tmpDir);

        // Transform templates URLs like src='/assets/base64/file.jpg' to src='file.jpg'
        $html = $this->getContentWithUntransformedAssetsUrls(
            $alsoUntransformUserAssets = true,
            function ($userAssetFile, &$basename) use ($tmpDir) {
                $basename = StringHelper::generateUniqueName($tmpDir, $basename);
                $copyPath = join_paths($tmpDir, $basename);
                \App\Helpers\pcopy($userAssetFile, $copyPath);
            }
        );

        // Create index.html
        file_put_contents($indexFile, $html);

        // Make zip file
        Tool::zip($tmpDir, $tmpZipFile);

        // Clean up tmp directory
        File::deleteDirectory($tmpDir);

        // Return zip file for download
        return $tmpZipFile;
    }
    public function uploadThumbnail($file)
    {
        $file->move($this->getStoragePath(), 'thumbnail.png');
        // resize
        resize_crop_image(596, 769, $this->getStoragePath('thumbnail.png'), $this->getStoragePath('thumbnail.png'));
    }

    /**
     * Upload template thumbnail Url.
     *
     * @return mixed
     */
    public function uploadThumbnailUrl($url)
    {
        $contents = file_get_contents($url);
        file_put_contents($this->getStoragePath('thumbnail.png'), $contents);
        // resize
        resize_crop_image(596, 769, $this->getStoragePath('thumbnail.png'), $this->getStoragePath('thumbnail.png'));
    }
    public function uploadAssetFromBase64($base64)
    {
        // upload file by upload image
        $filename = uniqid();

        // Storage path of the uploaded asset:
        // For example: /storage/templates/{type}/{ID}/604ce5e36d0fa
        $filepath = $this->getStoragePath($filename);

        // Store it
        file_put_contents($filepath, file_get_contents($base64));
        $assetUrl = generatePublicPath($filepath);

        return $assetUrl;
    }

    public function uploadAssetFromUrl($url)
    {
        // upload file by upload image
        $filename = uniqid();

        // Storage path of the uploaded asset:
        // For example: /storage/templates/{type}/{ID}/604ce5e36d0fa
        $filepath = $this->getStoragePath($filename);

        // Download the file's content
        $content = file_get_contents($url);

        // Store it:
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        file_put_contents($filepath, $content, false, stream_context_create($arrContextOptions));
        $assetUrl =generatePublicPath($filepath);

        return $assetUrl;
    }

    /**
     * Upload asset.
     */
    public function uploadAsset($file)
    {
        // Store to template storage storage/app/customers/000000/templates/111111/ASSET.JPG
        $name = StringHelper::sanitizeFilename($file->getClientOriginalName());
        $name = StringHelper::generateUniqueName($this->getStoragePath(), $name);

        // Move uploaded file
        $file->move($this->getStoragePath(), $name);
        $assetUrl = generatePublicPath($this->getStoragePath($name));

        return $assetUrl;
    }
    public function findCssFiles()
    {
        // IMPORTANT
        // + No external CSS
        // + Only CSS in the template folder is considered
        $files = [];

        $document = new \DOMDocument();
        $document->loadHTML($this->content, LIBXML_NOWARNING | LIBXML_NOERROR);
        $links = $document->getElementsByTagName('link');
        foreach ($links as $link) {
            $href = $link->getAttribute('href');
            if (!empty($href)) {
                $path = $this->getAssetFileFromUrl($href);
                if ($path) {
                    $files[] = $path;
                }
            }
        }
        return $files;
    }

}
