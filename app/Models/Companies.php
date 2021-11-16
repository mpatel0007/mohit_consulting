<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Companies extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'companies';
	protected $fillable = [
        'companylogo','companyname ','companyemail','password','companyseo','industry_id','ownershiptype',
        'companydetail','location ','googlemap','numberofoffices','website','numberofemployees','establishedin',
        'fax','phone ','facebook','twitter','linkedin','google','pinterest','country_id','state_id ','city_id',
        'package_id','status','created_at','updated_at','token','user_id'
    ];
}
