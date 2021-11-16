<?php

namespace App\Http\Controllers\Front_end;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Userprofile;
use App\Models\Companies;
use App\Models\Emailtemplate;
use Carbon\Carbon;
use Mail;


class SigninController extends Controller
{
    public function signin()
    {
        return view('Front_end/layouts/login/login');
    }

    public function loginuser(Request $request)
    {
        // if ($request->userType == 'candidate') {
        //     $this->validate($request, [
        //         'email'   => 'required|email',
        //         'password' => 'required|min:3'
        //     ]);
        //     if (Auth::guard('candidate')->attempt(['email' => $request->email, 'password' => $request->password ])){
        //         $candidate_active_inactive = Auth::guard('candidate')->user()->active_inactive;
        //         if ($candidate_active_inactive == 1 ){
        //             return redirect()->intended('/home');
        //        }else{
        //            return redirect()->back()->with('error', 'You need to activate your account to login');
        //        }
        //     } else {
        //         return redirect()->back()->with('error', 'User does not exist Regiser First!');
        //     }  
        // }else{
        //     $this->validate($request, [
        //         'email'   => 'required|email',
        //         'password' => 'required|min:3'
        //     ]);
        //     if (Auth::guard('employers')->attempt(['companyemail' => $request->email, 'password' => $request->password ])){
        //         $company_active_inactive = Auth::guard('employers')->user()->active_inactive;
        //         if ($company_active_inactive == 1){
        //              return redirect()->intended('/home');
        //         }else{
        //             return redirect()->back()->with('error', 'You need to activate your account to login');
        //         }
        //     } else {
        //         return redirect()->back()->with('error', 'User does not exist Regiser First!');
        //     }
        // }

        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:3'
        ]);
        if (Auth::guard('candidate')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $candidate_active_inactive = Auth::guard('candidate')->user()->active_inactive;
            if ($candidate_active_inactive == 1) {
                return redirect()->intended('/home');
            } else {
                return redirect()->back()->with('error', 'You need to activate your account to login <br> Click<a href='. route('front_end-resend-account-active-view').' style="color: blue;"> here </a>for resend account activation mail');
                // return redirect()->back()->with('error', 'You need to activate your account to login' );
            }
        } else {
            return redirect()->back()->with('error', 'User does not exist Regiser First!');
        }
    }

    public function active_account($UserId, $UserType)
    {
        if ($UserType == 'Candidate') {
            $find_user = Userprofile::where('id', $UserId)->first();
            if ($find_user->active_inactive != '1') {
                $find_user->active_inactive = '1';
                $find_user->updated_at = Carbon::now();
                $find_user->save();
                if ($find_user) {
                    return redirect('/signin')->with('success', 'Your account has been activated Successfully..');
                }
            } else {
                return redirect('/signin')->with('error', 'Your account already activated.');
            }
        } else {
            $find_Companies = Companies::where('id', $UserId)->first();
            if ($find_Companies->active_inactive != '1') {
                $find_Companies->active_inactive = '1';
                $find_Companies->updated_at = Carbon::now();
                $find_Companies->save();
                if ($find_Companies) {
                    return redirect('/signin')->with('success', 'Your account has been activated Successfully..');
                }
            } else {
                return redirect('/signin')->with('error', 'Your account already activated.');
            }
        }
    }

    public function resend_account_activation_view()
    {
        return view('Front_end/layouts/email_template/resendmail');
    }

    public function resend_account_activation_mail(Request $request)
    {
        $this->validate($request, [
            'email'             => 'required|email',
        ], [
            'email.required'    => ' The Email field is required.',
        ]);
        $UseremailData = $request->all();
        if (!empty($UseremailData)) {
            $find_user = Userprofile::where('email', '=', $UseremailData['email'])->first();
            $CandidateId = $find_user->id;
            
            $template = Emailtemplate::where('template_name', 'register')->first();
            
            if ($find_user != "") {
                $data = [
                    'subject'     => $template->subject,
                    'description' => $template->description,
                    'email'       => $request['email'],
                    'name'        => $find_user->name,
                    'Userid'      => $CandidateId,
                    'UserType'    => 'Candidate',
                ];

                Mail::send('Front_end.layouts.register.email-template', ["data1" => $data], function ($message) use ($data) {
                    $message->to($data['email'])
                        ->subject($data['subject']);
                });
                return redirect('/signin')->with('success', 'We send you mail.Please check your email to activate account');
            } else {
                return redirect()->back()->with('error', 'User Not found please register first !.');
            }
        }
    }
    // public  function logout()
    // {
    //     if(Auth::guard('candidate')->check()){
    //         Auth::guard('candidate')->logout();
    //         return redirect('/signin');
    //     }
    //     elseif(Auth::guard('employers')->check()){
    //         auth()->guard()->logout();
    //         return redirect('/signin');   
    //     }
    // }

}
