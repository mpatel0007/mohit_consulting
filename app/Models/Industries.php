<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Industries extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'industries';
    public $timestamps = false;
    
    protected $fillable = [
        'industry_name','is_default','status','created_at','updated_at'
    ];

}
