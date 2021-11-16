<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Models\Careerlevel;

class CareerlevelController extends APIController
{
    public function list(){
        $Careerlevel = Careerlevel::where('status','1')->get();
        $json['data'] = $Careerlevel;
        return $this->respond($json);
    }
}
