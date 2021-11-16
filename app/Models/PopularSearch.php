<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PopularSearch extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'popular_search';
    public $timestamps = false;

    protected $fillable = [
        'id','popular_search','status','created_at','updated_at'
    ];

}


