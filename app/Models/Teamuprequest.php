<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Teamuprequest extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'teamup_request';
    public $timestamps = false;
    protected $fillable = [
       'id','team_id','candidate_id','status','created_at','updated_at'
    ];

}
