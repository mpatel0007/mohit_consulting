<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;


class CountryController extends APIController
{
    public function list(){
        $country = Country::where('status',1)->get();
        $json['data'] = $country;
        return $this->respond($json);
    }
    
}
