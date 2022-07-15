<?php

namespace App;

use App\Library\Traits\HasUid;
use Illuminate\Database\Eloquent\Model;

class TemplateCategory extends Model
{
    use HasUid;

    protected $fillable = [
        'name'
    ];
    public function templates()
    {
        return $this->belongsToMany('App\Template', 'templates_categories', 'category_id', 'template_id');
    }
}
