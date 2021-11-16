<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Models\Industries;

class CategoryController extends APIController
{
    public function list(){
        $data = Industries::select('id','industry_name')->where(['status'=>1,'is_default'=>'yes'])->get();
        return $this->respond($data);
    }
    public function all(){
        $data = Industries::where('status','1')->get();
        $json['data'] = $data;
        return $this->respond($json);
    }
}
