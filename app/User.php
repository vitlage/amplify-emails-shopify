<?php

namespace App;

use App\Template;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Osiset\ShopifyApp\Contracts\ShopModel as IShopModel;
use Osiset\ShopifyApp\Traits\ShopModel;

class User extends Authenticatable implements IShopModel
{
    use Notifiable;
    use ShopModel;

    public const BASE_DIR = 'app/customers'; // storage/customers/000000
    public const ATTACHMENTS_DIR = 'home/attachments';  // storage/customers/000000/home/files
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function products()
    {
        return $this->hasMany('App\Product','shop_id','id');
    }
     public function templates()
     {
         return $this->hasMany('App\Template','customer_id','id')->orderBy('created_at', 'desc');
     }
    public function copyTemplateAs(Template $template, $name)
    {
        $copy = $template->copy([
            'name' => $name,
            'customer_id' => $this->id
        ]);

        return $copy;
    }
    public function getBuilderTemplates()
    {
        $result = [];

        // Gallery
        $templates = \App\Template::where('customer_id', '=', null)
            ->orWhere('customer_id', '=', $this->id)
            ->orderBy('customer_id')
            ->get();

        foreach ($templates as $template) {
            $result[] = [
                'name' => $template->name,
                'url' => '', // action('CampaignController@templateChangeTemplate', ['uid' => $this->uid, 'template_uid' => $template->uid]),
                'thumbnail' => $template->getThumbUrl(),
            ];
        }

        return $result;
    }
    public function displayName()
    {
        return htmlspecialchars(trim($this->name));
    }
    public function readCache($key, $default = null)
    {
        $cache = json_decode($this->cache, true);
        if (is_null($cache)) {
            return $default;
        }
        if (array_key_exists($key, $cache)) {
            if (is_null($cache[$key])) {
                return $default;
            } else {
                return $cache[$key];
            }
        } else {
            return $default;
        }
    }

    public function getAttachmentsPath($path = null)
    {
        $base = $this->getBasePath(self::ATTACHMENTS_DIR);

        if (!\File::exists($base)) {
            \File::makeDirectory($base, 0777, true, true);
        }

        return join_paths($base, $path);
    }
    public function getBasePath($path = null)
    {
        $base = storage_path(join_paths(self::BASE_DIR, $this->id)); // storage/app/customers/000000/

        if (!\File::exists($base)) {
            \File::makeDirectory($base, 0777, true, true);
        }

        return join_paths($base, $path);
    }
}
