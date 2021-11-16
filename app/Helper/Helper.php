<?php
namespace App\Http\Controllers\Auth;
namespace App\Helper;

use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Setting;
use App\Models\Userprofile;
use App\Models\Companies;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Package;
use Stripe;
use Carbon\Carbon;  

class Helper    
{  
	public static function isSubscribed() {
		$userID = Auth::guard('candidate')->id();
		$currentDate = date("Y-m-d");
		$condition = [['user_id','=',$userID],['ends_at','>=',$currentDate]];

		$data = DB::table('subscriptions')->where($condition)->whereIn('candidate',array('0','1'))->get()->toArray();        
		
		if(!empty($data)) {    
			return true;
		} else {
			header("Location:/candidate/packages?msg=1");
			exit; 
		}
	}

	public static function isEmployers(){
		$userID = Auth::guard('candidate')->id();
		$currentDate = date("Y-m-d");
		$condition = [['user_id','=',$userID],['ends_at','>=',$currentDate],['candidate','=','0']];

		$data = DB::table('subscriptions')->where($condition)->get()->toArray();      
		
		if(!empty($data)) {    
			return true;
		} else {
			header("Location:/candidate/packages?msg=1");
			exit;  
		}
	}

	public static function CountOfRequest(){
		$data = DB::table('teamup_request')
		->select('teamup_request.*','team_name.team_name as team_name', 'users.name as team_creator_name','team_name.team_creator as team_creator_id')
		->leftjoin("team_name", "team_name.id", "=", "teamup_request.team_id")
		->leftjoin("users","users.id","team_name.team_creator")
		->where("candidate_id",Auth::guard('candidate')->id())  
		->where("status",2)
		->count();
		return $data;
	}

	public static function addLog($message,$body,$userID) {
		DB::table('stripe_logs')->insert([
			'user_id' => $userID,
			'logs' =>$body,
			'message'=> $message,
			'is_candidate'=>0,        
		]);
	}

	public static function createCustomer($cardName,$email,$token,$address,$country,$state,$city) {
		Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
		$customer = Stripe\Customer::create ([        
			"name" => $cardName,
			"email" => $email,
			"source" => $token,
			"description" => "Payment from test",
			"shipping"=> array('address'=>array("line1"=>$address,"city"=>$city,"country"=>$country,"state"=>$state),'name'=>$cardName)
		]);
		return $customer;
	}

	public static function createSubscription($customerID,$itemsData,$userID,$lastEndDate) {
		Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
		if($lastEndDate == '') {
			$subscriptionData = Stripe\Subscription::create ([            
				"customer"=>$customerID,   
				'billing_cycle_anchor'=>'now',
				'items' => $itemsData,
				'metadata'=> array('userID'=>$userID)
			]);	
		} else {
			$subscriptionData = Stripe\Subscription::create ([            
				"customer"=>$customerID,   
				//'billing_cycle_anchor'=>strtotime($lastEndDate.'+1 day'),     
				'trial_end'=>strtotime($lastEndDate),
				'items' => $itemsData,
				'metadata'=> array('userID'=>$userID)
			]);
			//echo '<pre>'; print_r($subscriptionData); exit;
		}
		
		if(!empty($subscriptionData) && isset($subscriptionData->id)) {  
			$message = "Subscription ID -".$subscriptionData->id." Created";
			Helper::addLog($message,$subscriptionData,$userID);
		}
		return $subscriptionData;
	} 

	public static function cancelSubscription($subscriptionID,$userID) {
		Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
		$cancelSubscription = Stripe\Subscription::retrieve($subscriptionID);
			//echo '<pre>'; print_r($cancelSubscription); exit;
		$cancelData = $cancelSubscription->cancel();
		if(!empty($cancelData) && $cancelData->status == 'canceled') {    
			DB::table('subscriptions')->update([
				'is_downgraded'=>1,
				'stripe_status' => '0' 
			],array('user_id'=>$userID));    
		}
		$message = "Subscription ID -".$subscriptionID." Downraded";
		Helper::addLog($message,$cancelData,$userID);
		return $cancelData;	
	}

	public static function chargeCustomer($amount,$customerID,$userID) {
		Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
		$charge = Stripe\Charge::create ([        
			"amount" => $amount*100,
			"currency" => 'USD',
			"customer" => $customerID,
			"description" => "Payment from test"
		]);
		if(!empty($charge) && isset($charge->id)) {  
			$mytime = Carbon::now();
			DB::table('subscription_charges')->insert([
				'charge_id'=>$charge->id,
				'subscription_id'=>$customerID,
				'data'=> $charge,
				'created_at'=>$mytime,
			]);    
			$message = "Charge ID -".$charge->id." created";
			Helper::addLog($message,$charge,$userID);
		}
		return $charge;
	}


	public static function setting(){
		$setting = Setting::select()->first();
		return $setting;	
	}

}