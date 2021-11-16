<?php
    
    namespace App;
    
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    
    class Admin extends Authenticatable
    {
        use Notifiable;
    
        protected $guard = 'admin';
        protected $table = 'admin';
    
        protected $fillable = [
            'id','name','email','role_id','password','remember_token','created_at','updated_at','is_admin','userstatus'
        ];
    
        protected $hidden = [
            'password', 'remember_token',
        ];
    }