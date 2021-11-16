<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Jobs extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'jobs';
	protected $fillable = [
        'company_id','jobtitle ','jobdescription','jobskill_id','country_id','state_id','city_id',
        'is_freelance','careerlevel ','salaryfrom','salaryto','salaryperiod','hidesalary','functional_id',
        'jobtype','jobshift ','positions','gender','jobexprirydate','degreelevel_id','experience','status',
        'created_at ','updated_at','yearly_job_salary','industry_id','reject_reason'
    ];
    protected $casts = [
        'id' => 'integer',
        'country_id' => 'integer',
        'state_id' => 'integer',
        'salaryfrom' => 'integer',
        'salaryto' => 'integer',
        'industry_id' => 'integer',
        
    ];
}
