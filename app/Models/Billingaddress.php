<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billingaddress extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'billing_address';
	protected $fillable = [
        'id','candidate_id','address','country_id','state_id','city_id','created_at','updated_at'
    ];
}
