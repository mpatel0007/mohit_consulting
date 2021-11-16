<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Package extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'package';
    protected $fillable = [
        'package_title','package_price','package_num_days','package_num_listings','package_for','status','created_at','updated_at'
    ];

}
