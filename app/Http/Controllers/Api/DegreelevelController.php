<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Models\Degreelevel;

class DegreelevelController extends APIController
{
    public function list(){
        $Degreelevel = Degreelevel::where('status','1')->get();
        $json['data'] = $Degreelevel;
        return $this->respond($json);
    }
}
