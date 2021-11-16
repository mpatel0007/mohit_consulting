<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class EmployeeData extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'employee_data';
	protected $fillable = [
        'employee_name','employee_salary ','employee_age'
    ];
    
}
