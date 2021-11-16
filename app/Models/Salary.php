<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Salary extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'salary';
    protected $fillable = [
        'id','salary','status','created_at','updated_at'
    ];

}
