<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Teamtask extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'team_tasks';
    protected $fillable = [
       'id','team_id','task_name','description','attachments','created_at','updated_at'
    ];

}
