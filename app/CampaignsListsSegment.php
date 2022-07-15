<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignsListsSegment extends Model
{
    public function campaign()
    {
        return $this->belongsTo('App\Campaign');
    }

    public function mailList()
    {
        return $this->belongsTo('App\Mail_list');
    }
}
