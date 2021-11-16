<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Models\Jobskill;

class SkillController extends APIController
{
    public function list(){
        $Jobskill = Jobskill::where('status','1')->get();
        $json['data'] = $Jobskill;
        return $this->respond($json);
    }
}
