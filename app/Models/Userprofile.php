<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Userprofile extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'users';
	protected $fillable = [
        'id','name ','email','email_verified_at','password','remember_token','created_at','updated_at','userstatus',
        'profileimg','fname ','mname','lname','fathername','dateofbirth','gender',
        'maritalstatus','country_id ','state_id','city_id','phone','mobile','experience',
        'careerlevel','industry_id ','functional_id','currentsalary','expectedsalary','streetaddress','is_admin','tokan','resume','is_company'
    ];
}
