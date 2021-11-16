<?php

namespace App\Http\Controllers\Front_end;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Candidate;
use App\Models\Emailtemplate;
use App\Employers;
use Illuminate\Support\Facades\Hash;
use Mail;
use Illuminate\Support\Facades\Redirect;
use DB;

class SignupController extends Controller
{

  public function signup()
  {
    return view('Front_end/layouts/register/register');
  }

  // public function addnewuser(Request $request)
  // {
  //   if ($request->userType == 'candidate') {
  //     $this->validate($request, [
  //       'name'                  => 'required',
  //       // 'gender'                => 'required',
  //       'email'                 => 'required|email|unique:users',
  //       'password'              => 'required|min:3|max:20',
  //       'confirm_password'      => 'required|min:3|max:20|same:password',
  //       'g-recaptcha-response'  => 'required|recaptcha'
  //     ], [
  //       'name.required'             => ' The Candidate name field is required.',
  //       // 'gender.required'           => ' The gender field is required.',
  //       'email.required'            => ' The Candidate Email field is required.',
  //       'password.required'         => ' The Password field is required.',
  //       'confirm_password.required' => ' The Confirm Password field is required.',
  //       'g-recaptcha-response.recaptcha' => 'Captcha verification failed',
  //       'g-recaptcha-response.required' => 'Please complete the captcha'
  //     ]);
  //     $Candidate = Candidate::create([
  //       // 'gender'   => $request['gender'],
  //       'email'    => $request['email'],
  //       'name'     => $request['name'],
  //       'password' => Hash::make($request['password']),
  //     ]);
  //     $CandidateId = $Candidate->id;
  //     $template = Emailtemplate::where('template_name', 'register')->first();
  //     if ($Candidate != "") {
  //       $data = [
  //         'subject'     => $template->subject,
  //         'description' => $template->description,
  //         'email'       => $request['email'],
  //         'name'        => $request['name'],
  //         'Userid'      => $CandidateId,
  //         'UserType'    => 'Candidate',
  //       ]; 

  //       Mail::send('Front_end.layouts.register.email-template', ["data1" => $data], function ($message) use ($data) {
  //         $message->to($data['email'])
  //           ->subject($data['subject']);
  //       });
  //       return redirect('/signin')->with('success', 'Account Created Successfully.Please check your email to activate account');
  //     } else {
  //       return redirect()->back()->with('error', 'Something went wrong.');
  //     }
  //   } else {
  //     $this->validate($request, [
  //       'employersname'       => 'required',
  //       'companyemail'        => 'required|email|unique:companies',
  //       'password'            => 'required|min:3|max:20',
  //       'confirm_password'    => 'required|min:3|max:20|same:password',
  //       'g-recaptcha-response' => 'required|recaptcha'
  //     ], [
  //       'employersname.required'        => 'The Employers name field is required.',
  //       'companyemail.required'         => 'The Employers Email field is required.',
  //       'password.required'             => 'The Password field is required.',
  //       'confirm_password.required'     => 'The Confirm Password field is required.',
  //       'g-recaptcha-response.recaptcha' => 'Captcha verification failed',
  //       'g-recaptcha-response.required' => 'Please complete the captcha'
  //     ]);
  //     $Employers = Employers::create([
  //       'companyname'     => $request['employersname'],
  //       'companyemail'    => $request['companyemail'],
  //       'password'        => Hash::make($request['password']),
  //     ]);
  //     $EmployersId = $Employers->id;
  //     $template = Emailtemplate::where('template_name', 'register')->first();
  //     if ($Employers != "") {
  //       $data = [
  //         'subject'     => $template->subject,
  //         'description' => $template->description,
  //         'email'       => $request['companyemail'],
  //         'name'        => $request['employersname'],
  //         'Userid'      => $EmployersId,
  //         'UserType'    => 'Employers',
  //       ];
  //       Mail::send('Front_end.layouts.register.email-template', ["data1" => $data], function ($message) use ($data) {
  //         $message->to($data['email'])
  //           ->subject($data['subject']);
  //       });
  //       return redirect('/signin')->with('success', 'Account Created Successfully.Please check your email to activate account');
  //     } else {
  //       return redirect()->back()->with('error', 'Something went wrong.');
  //     }
  //   }
  // }


  public function addnewuser(Request $request){

    if(env('IS_DEVELOPMET') == '1') {
      $this->validate($request, [
        'name'                  => 'required',
        'email'                 => 'required|email|unique:users',
        'password'              => 'required|min:3|max:20',
        'confirm_password'      => 'required|min:3|max:20|same:password',
      ], [
        'name.required'                   => 'The name field is required.',
        'email.required'                  => 'The Email field is required.',
        'password.required'               => 'The Password field is required.',
        'confirm_password.required'       => 'The Confirm Password field is required.',
      ]);
    } else {
      $this->validate($request, [
        'name'                  => 'required',
        'email'                 => 'required|email|unique:users',
        'password'              => 'required|min:3|max:20',
        'confirm_password'      => 'required|min:3|max:20|same:password',
        'g-recaptcha-response'  => 'required|recaptcha'
      ], [
        'name.required'                   => 'The name field is required.',
        'email.required'                  => 'The Email field is required.',
        'password.required'               => 'The Password field is required.',
        'confirm_password.required'       => 'The Confirm Password field is required.',
        'g-recaptcha-response.recaptcha'  => 'Captcha verification failed',
        'g-recaptcha-response.required'   => 'Please complete the captcha'
      ]);
    } 
    
    $Candidate = Candidate::create([
      // 'gender'   => $request['gender'],
      'email'    => $request['email'],
      'name'     => $request['name'],
      'password' => Hash::make($request['password']),
    ]);
    $CandidateId = $Candidate->id;
    DB::table('companies')->insert([
      'user_id' => $CandidateId
    ]);        
    $template = Emailtemplate::where('template_name', 'register')->first();
    if ($Candidate != "") {
      $data = [
        'subject'     => $template->subject,
        'description' => $template->description,
        'email'       => $request['email'],
        'name'        => $request['name'],
        'Userid'      => $CandidateId,
        'UserType'    => 'Candidate',
      ];

      Mail::send('Front_end.layouts.register.email-template', ["data1" => $data], function ($message) use ($data) {
        $message->to($data['email'])
        ->subject($data['subject']);
      });
      return redirect('/signin')->with('success', 'Account created successfully.Please check your email to activate account');
    } else {
      return redirect()->back()->with('error', 'Something went wrong.');
    }
  }
}
