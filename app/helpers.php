<?php

//namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;

function changeDateFormate($date,$date_format){
    echo Auth::guard('candidate')->user()->id; die;
    $userID = '';
    if(Auth::guard('candidate')->check()) {  
        $userID = Auth::guard('candidate')->user()->id;
        $data = User::select('*')->where('id','=',$userID)->get()->toArray();
    } else if(Auth::guard('employers')->check()) {
        $userID = Auth::guard('employers')->user()->id;
        $data = Companies::select('*')->where('id','=',$userID)->get()->toArray();
    }     

    if(!empty($data)) {    
        $start_date = $data[0]['start_date'];
        $next_payment_date = $data[0]['next_payment_date'];
        $current_payment_date = $data[0]['current_payment_date'];
        $currentDate = date("Y-m-d");
        $currentPackage = $data[0]['package_id'];

        echo $currentPackage; die;  

        if($currentDate<=$next_payment_date && $currentPackage>0) {  

            return true;    
        } else {
            return false;
        }
    } else {
        return false;   
    }
}
