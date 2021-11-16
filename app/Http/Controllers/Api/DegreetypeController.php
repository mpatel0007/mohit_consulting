<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Models\Degreetype;

class DegreetypeController extends APIController
{
    public function list(){
        $Degreetype = Degreetype::where('status','1')->get();
        $json['data'] = $Degreetype;
        return $this->respond($json);
    }
}
