<?php
    
    namespace App;
    
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Laravel\Passport\HasApiTokens;
    class Candidate extends Authenticatable
    {
        use HasApiTokens, Notifiable;
        protected $guard = 'candidate';
	    protected $table = 'users';
    
        protected $fillable = [
            'id','name','email','email_verified_at','password','remember_token','created_at','updated_at','userstatus',
            'profileimg','mname','lname','dateofbirth','gender','is_company',
            'maritalstatus','country_id','state_id','city_id','phone','mobile','experience',
            'careerlevel','industry_id','functional_id','currentsalary','expectedsalary','streetaddress','is_admin','tokan'
        ];
        protected $hidden = [
            'password', 'token',
        ];
    }