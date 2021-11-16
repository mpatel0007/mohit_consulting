<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Userprofile;
use Mail;
use App\Helper\Helper;
use Carbon\Carbon;  

class dailyStripe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:stripe';     

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {   
       $subscriptionsData = DB::table('subscriptions')->where('stripe_status',1)->get()->toArray();      
       if(!empty($subscriptionsData)) {
            foreach($subscriptionsData as $key => $value) {
                $id = $value->id;
                $userID = $value->user_id;
                $customerID = $value->stripe_id;
                $packagePrice = $value->stripe_price;
                $subscriptionEndDate = date("Y-m-d",strtotime($value->ends_at."+29 days"));
                $chargeData = Helper::chargeCustomer($packagePrice,$customerID,$userID);
                if(!empty($charge) && isset($charge->id)) {  
                    DB::table('subscriptions')->update([
                        'ends_at'=>$subscriptionEndDate,
                    ],array('id'=>$id));
                } else {    
                    DB::table('subscriptions')->update([
                        'stripe_status'=>'0',
                    ],array('id'=>$id));
                }
            }
       }
       $this->info('Daily Update has been send successfully');
    }
}
