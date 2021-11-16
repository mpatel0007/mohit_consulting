<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\State;
use Illuminate\Support\Facades\Hash;

class StateController extends APIController
{
    public function list(){
        $State = State::where('status',1)->get();
        $json['data'] = $State;
        return $this->respond($json);
    }
    public function list_country($country_id = ''){
        if($country_id > 0){
            $country = State::where(['status'=>1,'country_id'=>$country_id])->get();
            $json['data'] = $country;
            return $this->respond($json);
        }else{
            $json['data'] = array();
            return $this->respond($json);
        }
        
    }
}
