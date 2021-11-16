<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Setting extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'setting';
    protected $fillable = [
        'headerlogo','footerlogo','infoaddress','infoemail','infocontactnumber','footerdiscription','facebook','twitter','linkedin','google','copyrightcontent','inquiryemail','created_at','updated_at'
    ];

}
