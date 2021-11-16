<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Models\EmployeeData;

class EmployeeDataController extends APIController
{
    public function list(){
        $EmployeeData = EmployeeData::all();
        return $this->respond($EmployeeData);
    }
}
