<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignManagement extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'Campaign_Management';
	protected $fillable = [
        'id','name','description','campaign_for','created_at','updated_at','subject'
    ];
}
