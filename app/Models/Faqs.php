<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Faqs extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'faqs';
    protected $fillable = [
        'questioneditor','answereditor','status','created_at','updated_at'
    ];

}
