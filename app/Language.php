<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    //


    public function getBuilderLang()
    {
        return include join_paths($this->languageDir(), 'builder.php');
    }
    public function languageDir()
    {
        return resource_path(join_paths('lang', $this->code));
    }
}
