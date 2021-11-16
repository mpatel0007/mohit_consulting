<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function notification(Request $request) {
        $json = file_get_contents('php://input');
        $object = json_decode($json);
        Log::info(print_r($object, true));

        if(isset($object->type) && $object->type ==  'charge.succeeded') {
            DB::table('subscription_charges')->insert([
                'charge_id' => $object->data->object->id,
                'subscription_id' =>$subscriptionData->id,
                'data'=> $id
            ]);       
        }
    }              
}
