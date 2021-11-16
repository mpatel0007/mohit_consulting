<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Blogs extends Model    
{
    protected $primaryKey = 'id';
	protected $table = 'blogs';
    public $timestamps = false;

	protected $fillable = [
        'id','image','description','status','created_at','updated_at',
    ];
	protected $guarded = [];
}
