<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Teamname extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'team_name';
    protected $fillable = [
       'id','team_name','created_at','description','attachments','updated_at'
    ];

}
