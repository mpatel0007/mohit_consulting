<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Emailtemplate extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'email_template';
	protected $fillable = [
        'id','title','subject','template_name','description','created_at','updated_at'
    ];
}
