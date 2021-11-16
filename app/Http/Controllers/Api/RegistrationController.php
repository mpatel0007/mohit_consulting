<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Candidate;
use App\Employers;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Models\Userprofiledegreelevel;
use App\Models\Userprofilefunctionalarea;
use App\Models\Userprofileskilllevel;
use Exception;
use DB;
use App\Models\Emailtemplate;
class RegistrationController extends APIController
{
 
    public function SignUp(Request $request){
        $result['status'] = 0;
        $result['msg'] = 'There is Some Error User Not Created.!';
        $validation = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        
        $Candidate = Candidate::create([
            // 'gender'   => $request['gender'],
            'email'    => $request->email,
            'name'     => $request->name,
            'password' => Hash::make($request->password)
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
              'email'    => $request->email,
              'name'     => $request->name,
              'Userid'      => $CandidateId,
              'UserType'    => 'Candidate',
            ];
      
            Mail::send('Front_end.layouts.register.email-template', ["data1" => $data], function ($message) use ($data) {
              $message->to($data['email'])
              ->subject($data['subject']);
            });
            $result['status'] = 1;
            $result['msg'] = 'Account created successfully.Please check your email to activate account.';
            return $this->respond($result);
        
        }else{
            $result['status'] = 0;
            $result['msg'] = 'Something went wrong.';
            return $this->respond($result);
        }
        
    }
    public function SignIn(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email'=>'required|email',
            //'signin_type'=>['required',Rule::in(['Candidate', 'Employers'])],
            'password'=>'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        
        
            
        if (Auth::guard('candidate')->attempt(['email' => $request->email, 'password' => $request->password])){
            $candidate_active_inactive = Auth::guard('candidate')->user()->active_inactive;
            if ($candidate_active_inactive == 1) {
                $access_token = 'Candidate_token';
                $user = Auth::guard('candidate')->user();
                if($user->resume != null){
                    $user->resume = url('/assets/front_end/Upload/User_Resume/'.$user->resume);
                }
                if($user->coverletter != null){
                    $user->coverletter = url('/assets/front_end/Upload/User_Cover_Letter/'.$user->coverletter);
                }
                if($user->references != null){
                    $user->references = url('/assets/front_end/Upload/User_References/'.$user->references);
                }
                $tokenResult = $user->createToken($access_token);
                    $token = $tokenResult->token;
                    $token->save();
                    $user['role'] = "candidate";
                $json = $this->setData("user", $user);
                $Userprofiledegreelevel = Userprofiledegreelevel::select('degreelevel.degreelevel','userprofile_degreelevel.*')->join('degreelevel','degreelevel.id','userprofile_degreelevel.degreelevel_id')->where('userprofile_id',$user->id)->get();
                $Userprofilefunctionalarea = Userprofilefunctionalarea::select('userprofile_functionalarea.*','functional_area.functional_area','industries.industry_name')
                                            ->join('functional_area','functional_area.id','userprofile_functionalarea.functional_area_id')
                                            ->join('industries','industries.id','functional_area.industry_id')
                                            ->where('userprofile_functionalarea.userprofile_id',$user->id)->get();
                $userSkill = Userprofileskilllevel::select('userprofile_skilllevel.*','careerlevel.careerlevel','jobskill.jobskill')
                            ->join('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                            ->join('careerlevel','careerlevel.id','userprofile_skilllevel.level_id')
                            ->where('userprofile_skilllevel.userprofile_id',$user->id)->get();
                $json['user']['degreelevels'] = $Userprofiledegreelevel;
                $json['user']['functionalareas'] = $Userprofilefunctionalarea;
                $json['user']['skill'] = $userSkill;
                $json['token']=$tokenResult->accessToken;
                return $this->respond($json);
            }else{
                return $this->noRespondWithMessage('You need to activate your account to login.');
                
            }
            
        } else {
            return $this->noRespondWithMessage('User not Found.');
        }
    }
    
}
