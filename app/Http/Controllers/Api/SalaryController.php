<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Models\Salary;

class SalaryController extends APIController
{
    public function list(){
        $Salary = Salary::where('status','1')->get();
        $json['data'] = $Salary;
        return $this->respond($json);
    }
}
