<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Testimonial extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'testimonial';
    protected $fillable = [
        'testimonial_by','testimonial','company_and_designation','is_default','status','created_at','updated_at'
        
    ];

}
