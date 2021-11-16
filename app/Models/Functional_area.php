<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Functional_area extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'functional_area';
    protected $fillable = [
        'id','functional_area','status','created_at','updated_at','industry_id'
    ];
    protected $casts = [
        'id' => 'integer',
        'industry_id' => 'integer',
        
    ];

}
