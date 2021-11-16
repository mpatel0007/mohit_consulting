<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Functional_area;
use App\Employers;
use Illuminate\Support\Facades\Hash;
use Mail;
use Exception;
class SubcategoryController extends APIController
{
    public function list(){
        $Functional_area = Functional_area::where('status','1')->get();
        $json['data'] = $Functional_area;
        return $this->respond($json);
    }
}
