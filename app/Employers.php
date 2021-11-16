<?php
    
    namespace App;
    
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    
    class Employers extends Authenticatable
    {
        use Notifiable;
    
        protected $guard = 'employers';
    	protected $table = 'companies';

    
        protected $fillable = [
            'companylogo','companyname','companyemail','password','companyseo','industry_id','ownershiptype',
            'companydetail','location ','googlemap','numberofoffices','website','numberofemployees','establishedin',
            'fax','phone ','facebook','twitter','linkedin','google','pinterest','country_id','state_id ','city_id',
            'package_id','status','created_at','updated_at','token'
        ];
    
        // protected $hidden = [
        //     'password', '_token',
        // ];
    }