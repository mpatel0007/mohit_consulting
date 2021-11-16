<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Contact extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'contact';
    protected $fillable = [
       'name','email','msg_subject','message','created_at','updated_at'
    ];

}
