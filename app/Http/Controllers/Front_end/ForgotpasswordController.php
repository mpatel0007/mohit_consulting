<?php

namespace App\Http\Controllers\Front_end;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Userprofile;
use App\Models\Companies;
use App\Models\Emailtemplate;
use Illuminate\Support\Facades\Hash;
use Mail;


class ForgotpasswordController extends Controller
{
     public function forgotpassword(){
    	  return view('Front_end/layouts/forgotpassword/forgotpassword');
      }

    public function changepassword(Request $request){
      $this->validate($request,[
        'email'             => 'required|email',
      ],[
        'email.required'    => ' The Email field is required.',
        ]);
        $UseremailData = $request->all();
          if(!empty($UseremailData)){
            // if($UseremailData['userType'] == 'candidate'){
                $find_user = Userprofile::where('email', '=', $UseremailData['email'])->first();    
                    if($find_user != "" && $find_user != null){
                      $find_user->tokan =  $UseremailData['_token'];
                      $find_user->save();
                      $template = Emailtemplate::where('template_name','forgotpassword')->first();
                      $data = [
                        'subject'      => $template->subject,
                        'description'  => $template->description,
                        'email'        => $UseremailData['email'],
                        'token'        => $UseremailData['_token'],
                        'hid'          => 'candidate',
                      ];
                      Mail::send('Front_end.layouts.forgotpassword.forgotpassword-template',["userdata"=>$data] , function($message) use ($data) {
                        $message->to($data['email'])
                        ->subject($data['subject']);
                      });
                    return redirect('/signin')->with('success','We send Password Re-set link in Your Register Account');
                    } else {
                      return redirect('/signin')->with('error', 'User does not exist Regiser First!');
                  }    
            // }else{
            //     $User_profile = new Companies();
            //     $find_user = Companies::where('companyemail', '=', $UseremailData['email'])->first();    
            //         if($find_user != "" && $find_user != null){
            //           $find_user->token =  $UseremailData['_token'];
            //           $find_user->save();
            //           $template = Emailtemplate::where('template_name','forgotpassword')->first();
            //           $data = [
            //             'subject'      => $template->subject,
            //             'description'  => $template->description,
            //             'email'        => $UseremailData['email'],
            //             'token'        => $UseremailData['_token'],
            //             'hid'          => 'employers',
            //           ];
            //           Mail::send('Front_end.layouts.forgotpassword.forgotpassword-template',["userdata"=>$data] , function($message) use ($data) {
            //             $message->to($data['email'])
            //             ->subject($data['subject']);
            //           });
            //         return redirect('/signin')->with('success','We send Password Re-set link in Your Register Account');
            //         } else {
            //         return redirect('/signin')->with('error', 'User does not exist Regiser First!');
            //       }    
            // }
        }
    }

    public function newpassword($hid,$token){
      $newpasswordtoken = $token;
      $newpasswordhid = $hid;
      return view('Front_end/layouts/forgotpassword/newpassword')->with(compact('newpasswordtoken','newpasswordhid'));
    }

    public function setnewpassword(Request $request){
      $this->validate($request,[
        'password'              => 'required|min:3|max:20',
        'confirm_password'      => 'required|min:3|max:20|same:password',
      ],[
        'passwoed.required'    => 'The password field is required.',
        'confirm_password.required'    => 'The Confirm Password field is required.',
        ]);

      $Usernewpassword = $request->all();
      if(!empty($Usernewpassword)){
        if($Usernewpassword['newpasswordhid'] == 'candidate' ){
            $find_user = Userprofile::where('tokan', '=', $Usernewpassword['newpasswordtoken'])->first();
        }else{
          $find_user = Companies::where('token', '=', $Usernewpassword['newpasswordtoken'])->first();
        }
      
        if($find_user != '' && $find_user != null){
              if($Usernewpassword['password'] == $Usernewpassword['confirm_password']){
                $find_user->password =  Hash::make($Usernewpassword['password']);
                $find_user->save(); 
              }else{
                return back()->with('Password and confirm password does not match');
              }
          }
      }
      return redirect('/signin')->with('success','Your password Change successfully');
    }
}