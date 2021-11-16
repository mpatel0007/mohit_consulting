<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Major_subject extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'major_subject';
    protected $fillable = [
        'major_subject','status','created_at','updated_at'
    ];

}
