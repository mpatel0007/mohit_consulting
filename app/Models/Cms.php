<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Cms extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'cms';
	protected $fillable = [
        'title','slug ','descriptioneditor','metatitle','metakeyword','metadescription','status','created_at','updated_at'
    ];
}
