<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Candidatetask extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'candidate_task';
    public $timestamps = false;
    protected $fillable = [
       'id','team_id','candidate_id','task_id','created_at','updated_at'
    ];

}
