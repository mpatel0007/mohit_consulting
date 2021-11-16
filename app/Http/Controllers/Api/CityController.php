<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\City;
use Illuminate\Support\Facades\Hash;

class CityController extends APIController
{
    public function list(){
        $City = City::where('status',1)->get();
        $json['data'] = $City;
        return $this->respond($json);
    }
    public function list_state($state_id = ''){
        if($state_id > 0){
            $City = City::where(['status'=>1,'state_id'=>$state_id])->get();
            $json['data'] = $City;
            return $this->respond($json);
        }else{
            $json['data'] = array();
            return $this->respond($json);
        }
        
    }
}
