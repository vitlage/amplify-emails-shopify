<?php

namespace App;

use App\Library\Traits\HasUid;
use Illuminate\Database\Eloquent\Model;

class Mail_list extends Model
{
    use HasUid;


    public function has_subscriber(){
        return  $this->belongsToMany(Customer::class,'customer_lists','list_id','customer_id');
    }
    public function has_country(){
        return $this->hasOne(Country::class,'id','country_id');
    }
}
