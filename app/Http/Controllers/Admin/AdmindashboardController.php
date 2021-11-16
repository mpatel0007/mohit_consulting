<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models;
use App\Models\User;
use App\Models\Jobs;

class AdmindashboardController extends Controller
{
    public function index(){
        $totalUser = User::select()->get()->count();
        $totalCompanies = User::select()->where('is_company',1)->get()->count();
        $totalJobs = Jobs::select()->get()->count(); 
        
    	return view('Admin/dashboard')->with(compact('totalUser','totalCompanies','totalJobs'));
    }
}