<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ApplicationRejectReason extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'application_reject_reason';
    public $timestamps = false;

    protected $fillable = [
        'id','application_reject_subject','application_reject_description','job_id','candidate_id','created_at','updated_at'
    ];

}