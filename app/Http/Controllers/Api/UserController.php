<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Candidate;
use App\Models\Userprofilefunctionalarea;
use App\Models\Userprofileskilllevel;
use App\Models\Userprofiledegreelevel;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class UserController extends APIController
{
    public function changepassword(Request $request){
        $validation = Validator::make($request->all(), [
            'oldpassword'=>'required',
            'password'=>'required|min:6',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            $Candidate = Candidate::where('id', '=', Auth::user()->id)->first();
            if(!empty($Candidate)){
                if(Hash::check($request->oldpassword, $Candidate->password)){
                    $Candidate->password     =  Hash::make($request->password);
                    $Candidate->updated_at   = Carbon::now();
                    $Candidate->save();
                    $json['status'] = 1;
                    $json['msg'] = "Password Change Successfully";
                    return $this->respond($json);
                }else{
                    return $this->noRespondWithMessage('The old password you have entered is incorrect');
                }
            }else{
                return $this->noRespondWithMessage('User not found.!');
            }
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }

    }
    public function profile(){
        if (Auth::check()) {
            
            $Candidate = Candidate::select('users.*','country.country_name','state.state_name','city.city_name')
                        ->leftJoin('country','country.id','users.country_id')
                        ->leftJoin('state','state.id','users.state_id')
                        ->leftJoin('city','city.id','users.city_id')
                        ->where('users.id',Auth::user()->id)->first();
            if($Candidate->resume != null){
                $Candidate->resume = url('/assets/front_end/Upload/User_Resume/'.$Candidate->resume);
            }
            if($Candidate->coverletter != null){
                $Candidate->coverletter = url('/assets/front_end/Upload/User_Cover_Letter/'.$Candidate->coverletter);
            }
            if($Candidate->references != null){
                $Candidate->references = url('/assets/front_end/Upload/User_References/'.$Candidate->references);
            }
            if(!empty($Candidate)){
                $Userprofiledegreelevel = Userprofiledegreelevel::select('degreelevel.degreelevel','userprofile_degreelevel.*')->leftJoin('degreelevel','degreelevel.id','userprofile_degreelevel.degreelevel_id')->where('userprofile_id',Auth::user()->id)->get();
                $Userprofilefunctionalarea = Userprofilefunctionalarea::select('userprofile_functionalarea.*','functional_area.functional_area','industries.industry_name')
                                            ->leftJoin('functional_area','functional_area.id','userprofile_functionalarea.functional_area_id')
                                            ->leftJoin('industries','industries.id','functional_area.industry_id')
                                            ->where('userprofile_functionalarea.userprofile_id',Auth::user()->id)->get();
                $userSkill = Userprofileskilllevel::select('userprofile_skilllevel.*','careerlevel.careerlevel','jobskill.jobskill')
                            ->leftJoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                            ->leftJoin('careerlevel','careerlevel.id','userprofile_skilllevel.level_id')
                            ->where('userprofile_skilllevel.userprofile_id',Auth::user()->id)->get();
                $json['data'] = $Candidate;
                $json['data']['degreelevels'] = $Userprofiledegreelevel;
                $json['data']['functionalareas'] = $Userprofilefunctionalarea;
                $json['data']['skill'] = $userSkill;
                return $this->respond($json);
            }else{
                return $this->noRespondWithMessage('User not found.!');
            }
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
    public function upload_profile_pic(Request $request){
        $validation = Validator::make($request->all(), [
            'profile_pic'     => 'required',
            
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            
                
                $candidate_id = Auth::user()->id;
                $Userprofile = Candidate::where('id', $candidate_id)->first();
                if(empty($Userprofile)){
                    return $this->noRespondWithMessage('User not Found.!');
                }
                $Userprofile->profileimg       = $request->profile_pic;
                $Userprofile->updated_at   = Carbon::now();
                $Userprofile->save();
                $Candidate = Candidate::select('users.*','country.country_name','state.state_name','city.city_name')
                            ->leftJoin('country','country.id','users.country_id')
                            ->leftJoin('state','state.id','users.state_id')
                            ->leftJoin('city','city.id','users.city_id')
                            ->where('users.id',Auth::user()->id)->first();
                if($Candidate->resume != null){
                    $Candidate->resume = url('/assets/front_end/Upload/User_Resume/'.$Candidate->resume);
                }
                if($Candidate->coverletter != null){
                    $Candidate->coverletter = url('/assets/front_end/Upload/User_Cover_Letter/'.$Candidate->coverletter);
                }
                if($Candidate->references != null){
                    $Candidate->references = url('/assets/front_end/Upload/User_References/'.$Candidate->references);
                }
                if(!empty($Candidate)){
                    $Userprofiledegreelevel = Userprofiledegreelevel::select('degreelevel.degreelevel','userprofile_degreelevel.*')->leftJoin('degreelevel','degreelevel.id','userprofile_degreelevel.degreelevel_id')->where('userprofile_id',Auth::user()->id)->get();
                    $Userprofilefunctionalarea = Userprofilefunctionalarea::select('userprofile_functionalarea.*','functional_area.functional_area','industries.industry_name')
                                                ->leftJoin('functional_area','functional_area.id','userprofile_functionalarea.functional_area_id')
                                                ->leftJoin('industries','industries.id','functional_area.industry_id')
                                                ->where('userprofile_functionalarea.userprofile_id',Auth::user()->id)->get();
                    $userSkill = Userprofileskilllevel::select('userprofile_skilllevel.*','careerlevel.careerlevel','jobskill.jobskill')
                                ->leftJoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                                ->leftJoin('careerlevel','careerlevel.id','userprofile_skilllevel.level_id')
                                ->where('userprofile_skilllevel.userprofile_id',Auth::user()->id)->get();
                    $json['data'] = $Candidate;
                    $json['data']['degreelevels'] = $Userprofiledegreelevel;
                    $json['data']['functionalareas'] = $Userprofilefunctionalarea;
                    $json['data']['skill'] = $userSkill;
                    $json['msg'] = "Profile Update Successfully.!";
                    return $this->respond($json);
                }else{
                    return $this->noRespondWithMessage('User not found.!');
                }  
            
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
        
    }
    public function upload_document(Request $request){
        $validation = Validator::make($request->all(), [
            'upload_resume'     => 'required|file|mimes:pdf,doc,docx|max:2048',
            'type'=>'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            
                // $csv_data = $request->file('upload_resume');
                // $extension = $request->file('upload_resume')->getClientOriginalExtension();
                // $Resume_name = time().'.'.$extension;  
                // $request->file('upload_resume')->move(public_path('assets/front_end/Upload/User_Resume'), $Resume_name);
                // if(!empty($Resume_name)){
                //     $candidate_id = Auth::user()->id;
                //     $Userprofile = Candidate::where('id', $candidate_id)->first();
                //     $resume = public_path('assets/front_end/Upload/User_Resume/'.$Userprofile->resume);
                //     if($Userprofile->resume != '' && $Userprofile->resume != null && file_exists($resume)){
                //         unlink($resume);
                //     }
                //     $Userprofile->resume       = $Resume_name;
                //     $Userprofile->updated_at   = Carbon::now();
                //     $Userprofile->save();
                    

                //     $Candidate = Candidate::select('users.*','country.country_name','state.state_name','city.city_name')
                //                 ->leftJoin('country','country.id','users.country_id')
                //                 ->leftJoin('state','state.id','users.state_id')
                //                 ->leftJoin('city','city.id','users.city_id')
                //                 ->where('users.id',Auth::user()->id)->first();
                //     if($Candidate->resume != null){
                //         $Candidate->resume = url('/assets/front_end/Upload/User_Resume/'.$Candidate->resume);
                //     }
                //     if($Candidate->coverletter != null){
                //         $Candidate->coverletter = url('/assets/front_end/Upload/User_Cover_Letter/'.$Candidate->coverletter);
                //     }
                //     if($Candidate->references != null){
                //         $Candidate->references = url('/assets/front_end/Upload/User_References/'.$Candidate->references);
                //     }
                //     $Userprofiledegreelevel = Userprofiledegreelevel::select('degreelevel.degreelevel','userprofile_degreelevel.*')->leftJoin('degreelevel','degreelevel.id','userprofile_degreelevel.degreelevel_id')->where('userprofile_id',Auth::user()->id)->get();
                //     $Userprofilefunctionalarea = Userprofilefunctionalarea::select('userprofile_functionalarea.*','functional_area.functional_area','industries.industry_name')
                //                                 ->leftJoin('functional_area','functional_area.id','userprofile_functionalarea.functional_area_id')
                //                                 ->leftJoin('industries','industries.id','functional_area.industry_id')
                //                                 ->where('userprofile_functionalarea.userprofile_id',Auth::user()->id)->get();
                //     $userSkill = Userprofileskilllevel::select('userprofile_skilllevel.*','careerlevel.careerlevel','jobskill.jobskill')
                //                 ->leftJoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                //                 ->leftJoin('careerlevel','careerlevel.id','userprofile_skilllevel.level_id')
                //                 ->where('userprofile_skilllevel.userprofile_id',Auth::user()->id)->get();
                //     $json['data'] = $Candidate;
                //     $json['data']['degreelevels'] = $Userprofiledegreelevel;
                //     $json['data']['functionalareas'] = $Userprofilefunctionalarea;
                //     $json['data']['skill'] = $userSkill;
                //     return $this->respond($json);
                    
                // }
                // $file = $request->file('upload_resume')->storeAs('public', "upload_resume.".$extension);
                // $storage_path = storage_path();
                // $csv_path = $storage_path.'/app/public/upload_resume.'.$extension;
                // $json['data'] = $csv_path;
                // return $this->respond($json);
            if($request->type == '1'){
                
                
                $extension = $request->file('upload_resume')->getClientOriginalExtension();
                $Resume_name = time().'.'.$extension;  
                $request->file('upload_resume')->move(public_path('assets/front_end/Upload/User_Resume'), $Resume_name);

                if(!empty($Resume_name)){
                $candidate_id = Auth::user()->id;
                $Userprofile = Candidate::where('id', $candidate_id)->first();
                $resume = public_path('assets/front_end/Upload/User_Resume/'.$Userprofile->resume);
                    if($Userprofile->resume != '' && $Userprofile->resume != null && file_exists($resume)){
                        unlink($resume);
                    }
                    $Userprofile->resume       = $Resume_name;
                    $Userprofile->updated_at   = Carbon::now();
                    $Userprofile->save();
                }
            }else if($request->type == '2'){
                $extension = $request->file('upload_resume')->getClientOriginalExtension();
                $coverletter_name = time().'.'.$extension;  
                $request->upload_resume->move(public_path('assets/front_end/Upload/User_Cover_Letter'), $coverletter_name);
                if(!empty($coverletter_name)){
                    $candidate_id = Auth::user()->id;
                    $Userprofile = Candidate::where('id', $candidate_id)->first();
                    $coverletter = public_path('assets/front_end/Upload/User_Cover_Letter/'.$Userprofile->coverletter);
                    if($Userprofile->coverletter != '' && $Userprofile->coverletter != null && file_exists($coverletter)){
                        unlink($coverletter);
                    }
                    $Userprofile->coverletter  = $coverletter_name;
                    $Userprofile->updated_at   = Carbon::now();
                    $Userprofile->save();
                    
                }
            }elseif($request->type == '3'){
                $extension = $request->file('upload_resume')->getClientOriginalExtension();
                $References_name = time().'.'.$extension;  
                $request->upload_resume->move(public_path('assets/front_end/Upload/User_References'), $References_name);
                if(!empty($References_name)){
                    $candidate_id = Auth::user()->id;
                    $Userprofile = Candidate::where('id', $candidate_id)->first();
                    $References = public_path('assets/front_end/Upload/User_References/'.$Userprofile->references);
                    if($Userprofile->references != '' && $Userprofile->references != null && file_exists($References)){
                        unlink($References);
                    }
                    $Userprofile->references   = $References_name;
                    $Userprofile->updated_at   = Carbon::now();
                    $Userprofile->save();
                    
                }
            }
            
            $Candidate = Candidate::select('users.*','country.country_name','state.state_name','city.city_name')
                                ->leftJoin('country','country.id','users.country_id')
                                ->leftJoin('state','state.id','users.state_id')
                                ->leftJoin('city','city.id','users.city_id')
                                ->where('users.id',Auth::user()->id)->first();
                if($Candidate->resume != null){
                    $Candidate->resume = url('/assets/front_end/Upload/User_Resume/'.$Candidate->resume);
                }
                if($Candidate->coverletter != null){
                    $Candidate->coverletter = url('/assets/front_end/Upload/User_Cover_Letter/'.$Candidate->coverletter);
                }
                if($Candidate->references != null){
                    $Candidate->references = url('/assets/front_end/Upload/User_References/'.$Candidate->references);
                }
                $Userprofiledegreelevel = Userprofiledegreelevel::select('degreelevel.degreelevel','userprofile_degreelevel.*')->leftJoin('degreelevel','degreelevel.id','userprofile_degreelevel.degreelevel_id')->where('userprofile_id',Auth::user()->id)->get();
                $Userprofilefunctionalarea = Userprofilefunctionalarea::select('userprofile_functionalarea.*','functional_area.functional_area','industries.industry_name')
                                            ->leftJoin('functional_area','functional_area.id','userprofile_functionalarea.functional_area_id')
                                            ->leftJoin('industries','industries.id','functional_area.industry_id')
                                            ->where('userprofile_functionalarea.userprofile_id',Auth::user()->id)->get();
                $userSkill = Userprofileskilllevel::select('userprofile_skilllevel.*','careerlevel.careerlevel','jobskill.jobskill')
                            ->leftJoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                            ->leftJoin('careerlevel','careerlevel.id','userprofile_skilllevel.level_id')
                            ->where('userprofile_skilllevel.userprofile_id',Auth::user()->id)->get();
                $json['data'] = $Candidate;
                $json['data']['degreelevels'] = $Userprofiledegreelevel;
                $json['data']['functionalareas'] = $Userprofilefunctionalarea;
                $json['data']['skill'] = $userSkill;
                $json['msg'] = "Document Update Successfully.!";
                return $this->respond($json);

        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
        
    }
    public function update_basic(Request $request){
        $validation = Validator::make($request->all(), [
            'fname'     => 'required',
            'lname'=>'required',
            'dateofbirth'=>'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
           
            $Candidate = Candidate::where('id',Auth::user()->id)->first();
            if(!empty($Candidate)){
                $Candidate->fname = $request->fname;
                $Candidate->lname = $request->lname;
                $Candidate->dateofbirth = date('Y-m-d', strtotime($request->dateofbirth));
                $Candidate->save();

                $Candidatedetails = Candidate::select('users.*','country.country_name','state.state_name','city.city_name')
                        ->leftJoin('country','country.id','users.country_id')
                        ->leftJoin('state','state.id','users.state_id')
                        ->leftJoin('city','city.id','users.city_id')
                        ->where('users.id',Auth::user()->id)->first();
                if($Candidatedetails->resume != null){
                    $Candidatedetails->resume = url('/assets/front_end/Upload/User_Resume/'.$Candidatedetails->resume);
                }
                if($Candidatedetails->coverletter != null){
                    $Candidatedetails->coverletter = url('/assets/front_end/Upload/User_Cover_Letter/'.$Candidatedetails->coverletter);
                }
                if($Candidatedetails->references != null){
                    $Candidatedetails->references = url('/assets/front_end/Upload/User_References/'.$Candidatedetails->references);
                }
                if(!empty($Candidatedetails)){
                    $Userprofiledegreelevel = Userprofiledegreelevel::select('degreelevel.degreelevel','userprofile_degreelevel.*')->leftJoin('degreelevel','degreelevel.id','userprofile_degreelevel.degreelevel_id')->where('userprofile_id',Auth::user()->id)->get();
                    $Userprofilefunctionalarea = Userprofilefunctionalarea::select('userprofile_functionalarea.*','functional_area.functional_area','industries.industry_name')
                                                ->leftJoin('functional_area','functional_area.id','userprofile_functionalarea.functional_area_id')
                                                ->leftJoin('industries','industries.id','functional_area.industry_id')
                                                ->where('userprofile_functionalarea.userprofile_id',Auth::user()->id)->get();
                    $userSkill = Userprofileskilllevel::select('userprofile_skilllevel.*','careerlevel.careerlevel','jobskill.jobskill')
                                ->leftJoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                                ->leftJoin('careerlevel','careerlevel.id','userprofile_skilllevel.level_id')
                                ->where('userprofile_skilllevel.userprofile_id',Auth::user()->id)->get();
                    $json['data'] = $Candidatedetails;
                    $json['data']['degreelevels'] = $Userprofiledegreelevel;
                    $json['data']['functionalareas'] = $Userprofilefunctionalarea;
                    $json['data']['skill'] = $userSkill;
                    $json['msg'] = "Profile Update Successfully.!";
                    return $this->respond($json);
                }else{
                    return $this->noRespondWithMessage('Candidate not found.!');    
                }
            }else{
                return $this->noRespondWithMessage('Candidate not found.!');    
            }
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
        
    }
    public function update_contact(Request $request){
        $validation = Validator::make($request->all(), [
            'mobile'     => 'required',
            'streetaddress'=>'required',
            'country_id'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
           
            $Candidate = Candidate::where('id',Auth::user()->id)->first();
            if(!empty($Candidate)){
                $Candidate->mobile = $request->mobile;
                $Candidate->streetaddress = $request->streetaddress;
                $Candidate->country_id = $request->country_id;
                $Candidate->state_id = $request->state_id;
                $Candidate->city_id = $request->city_id;
                $Candidate->save();

                $Candidatedetails = Candidate::select('users.*','country.country_name','state.state_name','city.city_name')
                        ->leftJoin('country','country.id','users.country_id')
                        ->leftJoin('state','state.id','users.state_id')
                        ->leftJoin('city','city.id','users.city_id')
                        ->where('users.id',Auth::user()->id)->first();
                if($Candidatedetails->resume != null){
                    $Candidatedetails->resume = url('/assets/front_end/Upload/User_Resume/'.$Candidatedetails->resume);
                }
                if($Candidatedetails->coverletter != null){
                    $Candidatedetails->coverletter = url('/assets/front_end/Upload/User_Cover_Letter/'.$Candidatedetails->coverletter);
                }
                if($Candidatedetails->references != null){
                    $Candidatedetails->references = url('/assets/front_end/Upload/User_References/'.$Candidatedetails->references);
                }
                if(!empty($Candidatedetails)){
                    $Userprofiledegreelevel = Userprofiledegreelevel::select('degreelevel.degreelevel','userprofile_degreelevel.*')->leftJoin('degreelevel','degreelevel.id','userprofile_degreelevel.degreelevel_id')->where('userprofile_id',Auth::user()->id)->get();
                    $Userprofilefunctionalarea = Userprofilefunctionalarea::select('userprofile_functionalarea.*','functional_area.functional_area','industries.industry_name')
                                                ->leftJoin('functional_area','functional_area.id','userprofile_functionalarea.functional_area_id')
                                                ->leftJoin('industries','industries.id','functional_area.industry_id')
                                                ->where('userprofile_functionalarea.userprofile_id',Auth::user()->id)->get();
                    $userSkill = Userprofileskilllevel::select('userprofile_skilllevel.*','careerlevel.careerlevel','jobskill.jobskill')
                                ->leftJoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                                ->leftJoin('careerlevel','careerlevel.id','userprofile_skilllevel.level_id')
                                ->where('userprofile_skilllevel.userprofile_id',Auth::user()->id)->get();
                    $json['data'] = $Candidatedetails;
                    $json['data']['degreelevels'] = $Userprofiledegreelevel;
                    $json['data']['functionalareas'] = $Userprofilefunctionalarea;
                    $json['data']['skill'] = $userSkill;
                    $json['msg'] = "Profile Update Successfully.!";
                    return $this->respond($json);
                }else{
                    return $this->noRespondWithMessage('Candidate not found.!');    
                }
            }else{
                return $this->noRespondWithMessage('Candidate not found.!');    
            }
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
        
    }
    public function update_experiance(Request $request){
        $validation = Validator::make($request->all(), [
            'experience'     => 'required',
            
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
           
            $Candidate = Candidate::where('id',Auth::user()->id)->first();
            if(!empty($Candidate)){
                $Candidate->experience = $request->experience;
                $Candidate->save();

                $Candidatedetails = Candidate::select('users.*','country.country_name','state.state_name','city.city_name')
                        ->leftJoin('country','country.id','users.country_id')
                        ->leftJoin('state','state.id','users.state_id')
                        ->leftJoin('city','city.id','users.city_id')
                        ->where('users.id',Auth::user()->id)->first();
                if($Candidatedetails->resume != null){
                    $Candidatedetails->resume = url('/assets/front_end/Upload/User_Resume/'.$Candidatedetails->resume);
                }
                if($Candidatedetails->coverletter != null){
                    $Candidatedetails->coverletter = url('/assets/front_end/Upload/User_Cover_Letter/'.$Candidatedetails->coverletter);
                }
                if($Candidatedetails->references != null){
                    $Candidatedetails->references = url('/assets/front_end/Upload/User_References/'.$Candidatedetails->references);
                }
                if(!empty($Candidatedetails)){
                    $Userprofiledegreelevel = Userprofiledegreelevel::select('degreelevel.degreelevel','userprofile_degreelevel.*')->leftJoin('degreelevel','degreelevel.id','userprofile_degreelevel.degreelevel_id')->where('userprofile_id',Auth::user()->id)->get();
                    $Userprofilefunctionalarea = Userprofilefunctionalarea::select('userprofile_functionalarea.*','functional_area.functional_area','industries.industry_name')
                                                ->leftJoin('functional_area','functional_area.id','userprofile_functionalarea.functional_area_id')
                                                ->leftJoin('industries','industries.id','functional_area.industry_id')
                                                ->where('userprofile_functionalarea.userprofile_id',Auth::user()->id)->get();
                    $userSkill = Userprofileskilllevel::select('userprofile_skilllevel.*','careerlevel.careerlevel','jobskill.jobskill')
                                ->leftJoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                                ->leftJoin('careerlevel','careerlevel.id','userprofile_skilllevel.level_id')
                                ->where('userprofile_skilllevel.userprofile_id',Auth::user()->id)->get();
                    $json['data'] = $Candidatedetails;
                    $json['data']['degreelevels'] = $Userprofiledegreelevel;
                    $json['data']['functionalareas'] = $Userprofilefunctionalarea;
                    $json['data']['skill'] = $userSkill;
                    $json['msg'] = "Profile Update Successfully.!";
                    return $this->respond($json);
                }else{
                    return $this->noRespondWithMessage('Candidate not found.!');    
                }
            }else{
                return $this->noRespondWithMessage('Candidate not found.!');    
            }
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
        
    }
    public function update_degreelevel(Request $request){
        $validation = Validator::make($request->all(), [
            'degreelevel'     => 'required|array',
            
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
           
            $Candidate = Candidate::where('id',Auth::user()->id)->first();
            if(!empty($Candidate)){
                foreach($request->degreelevel as $degreelevel){
                    
                    $Userprofiledegreelevel = Userprofiledegreelevel::where(['userprofile_id' => Auth::user()->id,'degreelevel_id'=>$degreelevel])->first();
                    
                    if(!empty($Userprofiledegreelevel)){
                        continue;
                    }else{
                        $Userprofiledegreelevel = new Userprofiledegreelevel();
                        $Userprofiledegreelevel->userprofile_id = Auth::user()->id;
                        $Userprofiledegreelevel->degreelevel_id = $degreelevel;
                        $Userprofiledegreelevel->created_at = Carbon::now();
                        $Userprofiledegreelevel->updated_at = Carbon::now();
                        $Userprofiledegreelevel->save();
                    }
                }
                
                $Candidatedetails = Candidate::select('users.*','country.country_name','state.state_name','city.city_name')
                        ->leftJoin('country','country.id','users.country_id')
                        ->leftJoin('state','state.id','users.state_id')
                        ->leftJoin('city','city.id','users.city_id')
                        ->where('users.id',Auth::user()->id)->first();
                if($Candidatedetails->resume != null){
                    $Candidatedetails->resume = url('/assets/front_end/Upload/User_Resume/'.$Candidatedetails->resume);
                }
                if($Candidatedetails->coverletter != null){
                    $Candidatedetails->coverletter = url('/assets/front_end/Upload/User_Cover_Letter/'.$Candidatedetails->coverletter);
                }
                if($Candidatedetails->references != null){
                    $Candidatedetails->references = url('/assets/front_end/Upload/User_References/'.$Candidatedetails->references);
                }
                if(!empty($Candidatedetails)){
                    $Userprofiledegreelevel = Userprofiledegreelevel::select('degreelevel.degreelevel','userprofile_degreelevel.*')->leftJoin('degreelevel','degreelevel.id','userprofile_degreelevel.degreelevel_id')->where('userprofile_id',Auth::user()->id)->get();
                    $Userprofilefunctionalarea = Userprofilefunctionalarea::select('userprofile_functionalarea.*','functional_area.functional_area','industries.industry_name')
                                                ->leftJoin('functional_area','functional_area.id','userprofile_functionalarea.functional_area_id')
                                                ->leftJoin('industries','industries.id','functional_area.industry_id')
                                                ->where('userprofile_functionalarea.userprofile_id',Auth::user()->id)->get();
                    $userSkill = Userprofileskilllevel::select('userprofile_skilllevel.*','careerlevel.careerlevel','jobskill.jobskill')
                                ->leftJoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                                ->leftJoin('careerlevel','careerlevel.id','userprofile_skilllevel.level_id')
                                ->where('userprofile_skilllevel.userprofile_id',Auth::user()->id)->get();
                    $json['data'] = $Candidatedetails; 
                    $json['data']['degreelevels'] = $Userprofiledegreelevel;
                    $json['data']['functionalareas'] = $Userprofilefunctionalarea;
                    $json['data']['skill'] = $userSkill;
                    $json['msg'] = "Profile Update Successfully.!";
                    return $this->respond($json);
                }else{
                    return $this->noRespondWithMessage('Candidate not found.!');    
                }
            }else{
                return $this->noRespondWithMessage('Candidate not found.!');    
            }
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
        
    }
    public function update_category(Request $request){
        $validation = Validator::make($request->all(), [
            'industry_id'     => 'required',
            'functional_area_id'     => 'required',
            
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
           
            $Candidate = Candidate::where('id',Auth::user()->id)->first();
            if(!empty($Candidate)){
                
                    
                    $Userprofilefunctionalarea_data = Userprofilefunctionalarea::where(['userprofile_id' => Auth::user()->id,'functional_area_id'=>$request->functional_area_id])->first();
                    
                    if(!empty($Userprofilefunctionalarea_data)){
                        return $this->noRespondWithMessage('Category Already added.!');    
                    }else{
                        $Userprofilefunctionalarea_class = new Userprofilefunctionalarea();
                        $Userprofilefunctionalarea_class->userprofile_id = Auth::user()->id;
                        $Userprofilefunctionalarea_class->functional_area_id = $request->functional_area_id;
                        $Userprofilefunctionalarea_class->created_at = Carbon::now();
                        $Userprofilefunctionalarea_class->updated_at = Carbon::now();
                        $Userprofilefunctionalarea_class->save();
                    }
                
                
                $Candidatedetails = Candidate::select('users.*','country.country_name','state.state_name','city.city_name')
                        ->leftJoin('country','country.id','users.country_id')
                        ->leftJoin('state','state.id','users.state_id')
                        ->leftJoin('city','city.id','users.city_id')
                        ->where('users.id',Auth::user()->id)->first();
                        if($Candidatedetails->resume != null){
                            $Candidatedetails->resume = url('/assets/front_end/Upload/User_Resume/'.$Candidatedetails->resume);
                        }
                        if($Candidatedetails->coverletter != null){
                            $Candidatedetails->coverletter = url('/assets/front_end/Upload/User_Cover_Letter/'.$Candidatedetails->coverletter);
                        }
                        if($Candidatedetails->references != null){
                            $Candidatedetails->references = url('/assets/front_end/Upload/User_References/'.$Candidatedetails->references);
                        }
                if(!empty($Candidatedetails)){
                    $Userprofiledegreelevel = Userprofiledegreelevel::select('degreelevel.degreelevel','userprofile_degreelevel.*')->leftJoin('degreelevel','degreelevel.id','userprofile_degreelevel.degreelevel_id')->where('userprofile_id',Auth::user()->id)->get();
                    $Userprofilefunctionalarea = Userprofilefunctionalarea::select('userprofile_functionalarea.*','functional_area.functional_area','industries.industry_name')
                                                ->leftJoin('functional_area','functional_area.id','userprofile_functionalarea.functional_area_id')
                                                ->leftJoin('industries','industries.id','functional_area.industry_id')
                                                ->where('userprofile_functionalarea.userprofile_id',Auth::user()->id)->get();
                    $userSkill = Userprofileskilllevel::select('userprofile_skilllevel.*','careerlevel.careerlevel','jobskill.jobskill')
                                ->leftJoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                                ->leftJoin('careerlevel','careerlevel.id','userprofile_skilllevel.level_id')
                                ->where('userprofile_skilllevel.userprofile_id',Auth::user()->id)->get();
                    $json['data'] = $Candidatedetails; 
                    $json['data']['degreelevels'] = $Userprofiledegreelevel;
                    $json['data']['functionalareas'] = $Userprofilefunctionalarea;
                    $json['data']['skill'] = $userSkill;
                    $json['msg'] = "Profile Update Successfully.!";
                    return $this->respond($json);
                }else{
                    return $this->noRespondWithMessage('Candidate not found.!');    
                }
            }else{
                return $this->noRespondWithMessage('Candidate not found.!');    
            }
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
        
    }
    public function update_skill(Request $request){
        $validation = Validator::make($request->all(), [
            'skill_id'     => 'required',
            'level_id'     => 'required',
            
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
           
            $Candidate = Candidate::where('id',Auth::user()->id)->first();
            if(!empty($Candidate)){
                
                    
                    $Userprofileskilllevel_data = Userprofileskilllevel::where(['userprofile_id' => Auth::user()->id,'skill_id'=>$request->skill_id])->first();
                    
                    if(!empty($Userprofileskilllevel_data)){
                        return $this->noRespondWithMessage('Skill Already added.!');    
                    }else{
                        $Userprofileskilllevel_class = new Userprofileskilllevel();
                        $Userprofileskilllevel_class->userprofile_id = Auth::user()->id;
                        $Userprofileskilllevel_class->skill_id = $request->skill_id;
                        $Userprofileskilllevel_class->level_id = $request->level_id;
                        $Userprofileskilllevel_class->created_at = Carbon::now();
                        $Userprofileskilllevel_class->updated_at = Carbon::now();
                        $Userprofileskilllevel_class->save();
                    }
                
                
                $Candidatedetails = Candidate::select('users.*','country.country_name','state.state_name','city.city_name')
                        ->leftJoin('country','country.id','users.country_id')
                        ->leftJoin('state','state.id','users.state_id')
                        ->leftJoin('city','city.id','users.city_id')
                        ->where('users.id',Auth::user()->id)->first();
                        if($Candidatedetails->resume != null){
                            $Candidatedetails->resume = url('/assets/front_end/Upload/User_Resume/'.$Candidatedetails->resume);
                        }
                        if($Candidatedetails->coverletter != null){
                            $Candidatedetails->coverletter = url('/assets/front_end/Upload/User_Cover_Letter/'.$Candidatedetails->coverletter);
                        }
                        if($Candidatedetails->references != null){
                            $Candidatedetails->references = url('/assets/front_end/Upload/User_References/'.$Candidatedetails->references);
                        }
                if(!empty($Candidatedetails)){
                    $Userprofiledegreelevel = Userprofiledegreelevel::select('degreelevel.degreelevel','userprofile_degreelevel.*')->leftJoin('degreelevel','degreelevel.id','userprofile_degreelevel.degreelevel_id')->where('userprofile_id',Auth::user()->id)->get();
                    $Userprofilefunctionalarea = Userprofilefunctionalarea::select('userprofile_functionalarea.*','functional_area.functional_area','industries.industry_name')
                                                ->leftJoin('functional_area','functional_area.id','userprofile_functionalarea.functional_area_id')
                                                ->leftJoin('industries','industries.id','functional_area.industry_id')
                                                ->where('userprofile_functionalarea.userprofile_id',Auth::user()->id)->get();
                    $userSkill = Userprofileskilllevel::select('userprofile_skilllevel.*','careerlevel.careerlevel','jobskill.jobskill')
                                ->leftJoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                                ->leftJoin('careerlevel','careerlevel.id','userprofile_skilllevel.level_id')
                                ->where('userprofile_skilllevel.userprofile_id',Auth::user()->id)->get();
                    $json['data'] = $Candidatedetails; 
                    $json['data']['degreelevels'] = $Userprofiledegreelevel;
                    $json['data']['functionalareas'] = $Userprofilefunctionalarea;
                    $json['data']['skill'] = $userSkill;
                    $json['msg'] = "Profile Update Successfully.!";
                    return $this->respond($json);
                }else{
                    return $this->noRespondWithMessage('Candidate not found.!');    
                }
            }else{
                return $this->noRespondWithMessage('Candidate not found.!');    
            }
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
        
    }
    public function delete_degreelevel(Request $request){
        $validation = Validator::make($request->all(), [
            'degreelevel_id'     => 'required',
            
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
           
            $Userprofiledegreelevel_data = Userprofiledegreelevel::where(['id'=>$request->degreelevel_id,'userprofile_id'=>Auth::user()->id])->first();
            if(!empty($Userprofiledegreelevel_data)){
                Userprofiledegreelevel::where('id', $request->degreelevel_id)->delete();
                
                $Candidatedetails = Candidate::select('users.*','country.country_name','state.state_name','city.city_name')
                        ->leftJoin('country','country.id','users.country_id')
                        ->leftJoin('state','state.id','users.state_id')
                        ->leftJoin('city','city.id','users.city_id')
                        ->where('users.id',Auth::user()->id)->first();
                        if($Candidatedetails->resume != null){
                            $Candidatedetails->resume = url('/assets/front_end/Upload/User_Resume/'.$Candidatedetails->resume);
                        }
                        if($Candidatedetails->coverletter != null){
                            $Candidatedetails->coverletter = url('/assets/front_end/Upload/User_Cover_Letter/'.$Candidatedetails->coverletter);
                        }
                        if($Candidatedetails->references != null){
                            $Candidatedetails->references = url('/assets/front_end/Upload/User_References/'.$Candidatedetails->references);
                        }
                if(!empty($Candidatedetails)){
                    $Userprofiledegreelevel = Userprofiledegreelevel::select('degreelevel.degreelevel','userprofile_degreelevel.*')->leftJoin('degreelevel','degreelevel.id','userprofile_degreelevel.degreelevel_id')->where('userprofile_id',Auth::user()->id)->get();
                    $Userprofilefunctionalarea = Userprofilefunctionalarea::select('userprofile_functionalarea.*','functional_area.functional_area','industries.industry_name')
                                                ->leftJoin('functional_area','functional_area.id','userprofile_functionalarea.functional_area_id')
                                                ->leftJoin('industries','industries.id','functional_area.industry_id')
                                                ->where('userprofile_functionalarea.userprofile_id',Auth::user()->id)->get();
                    $userSkill = Userprofileskilllevel::select('userprofile_skilllevel.*','careerlevel.careerlevel','jobskill.jobskill')
                                ->leftJoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                                ->leftJoin('careerlevel','careerlevel.id','userprofile_skilllevel.level_id')
                                ->where('userprofile_skilllevel.userprofile_id',Auth::user()->id)->get();
                    $json['data'] = $Candidatedetails; 
                    $json['data']['degreelevels'] = $Userprofiledegreelevel;
                    $json['data']['functionalareas'] = $Userprofilefunctionalarea;
                    $json['data']['skill'] = $userSkill;
                    $json['msg'] = "Profile Update Successfully.!";
                    return $this->respond($json);
                }else{
                    return $this->noRespondWithMessage('Candidate not found.!');    
                }
            }else{
                return $this->noRespondWithMessage('Degree level or user not found.!');    
            }
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
        
    }
    public function delete_category(Request $request){
        $validation = Validator::make($request->all(), [
            'functionalareas_id'     => 'required',
            
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
           
            $Userprofilefunctionalarea_data = Userprofilefunctionalarea::where(['id'=>$request->functionalareas_id,'userprofile_id'=>Auth::user()->id])->first();
            if(!empty($Userprofilefunctionalarea_data)){
                Userprofilefunctionalarea::where('id', $request->functionalareas_id)->delete();
                
                $Candidatedetails = Candidate::select('users.*','country.country_name','state.state_name','city.city_name')
                        ->leftJoin('country','country.id','users.country_id')
                        ->leftJoin('state','state.id','users.state_id')
                        ->leftJoin('city','city.id','users.city_id')
                        ->where('users.id',Auth::user()->id)->first();
                        if($Candidatedetails->resume != null){
                            $Candidatedetails->resume = url('/assets/front_end/Upload/User_Resume/'.$Candidatedetails->resume);
                        }
                        if($Candidatedetails->coverletter != null){
                            $Candidatedetails->coverletter = url('/assets/front_end/Upload/User_Cover_Letter/'.$Candidatedetails->coverletter);
                        }
                        if($Candidatedetails->references != null){
                            $Candidatedetails->references = url('/assets/front_end/Upload/User_References/'.$Candidatedetails->references);
                        }
                if(!empty($Candidatedetails)){
                    $Userprofiledegreelevel = Userprofiledegreelevel::select('degreelevel.degreelevel','userprofile_degreelevel.*')->leftJoin('degreelevel','degreelevel.id','userprofile_degreelevel.degreelevel_id')->where('userprofile_id',Auth::user()->id)->get();
                    $Userprofilefunctionalarea = Userprofilefunctionalarea::select('userprofile_functionalarea.*','functional_area.functional_area','industries.industry_name')
                                                ->leftJoin('functional_area','functional_area.id','userprofile_functionalarea.functional_area_id')
                                                ->leftJoin('industries','industries.id','functional_area.industry_id')
                                                ->where('userprofile_functionalarea.userprofile_id',Auth::user()->id)->get();
                    $userSkill = Userprofileskilllevel::select('userprofile_skilllevel.*','careerlevel.careerlevel','jobskill.jobskill')
                                ->leftJoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                                ->leftJoin('careerlevel','careerlevel.id','userprofile_skilllevel.level_id')
                                ->where('userprofile_skilllevel.userprofile_id',Auth::user()->id)->get();
                    $json['data'] = $Candidatedetails; 
                    $json['data']['degreelevels'] = $Userprofiledegreelevel;
                    $json['data']['functionalareas'] = $Userprofilefunctionalarea;
                    $json['data']['skill'] = $userSkill;
                    $json['msg'] = "Profile Update Successfully.!";
                    return $this->respond($json);
                }else{
                    return $this->noRespondWithMessage('Candidate not found.!');    
                }
            }else{
                return $this->noRespondWithMessage('Category or user not found.!');    
            }
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
        
    }
    public function delete_skill(Request $request){
        $validation = Validator::make($request->all(), [
            'skill_id'     => 'required',
            
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
           
            $Userprofileskilllevel_data = Userprofileskilllevel::where(['id'=>$request->skill_id,'userprofile_id'=>Auth::user()->id])->first();
            if(!empty($Userprofileskilllevel_data)){
                Userprofileskilllevel::where('id', $request->skill_id)->delete();
                
                $Candidatedetails = Candidate::select('users.*','country.country_name','state.state_name','city.city_name')
                        ->leftJoin('country','country.id','users.country_id')
                        ->leftJoin('state','state.id','users.state_id')
                        ->leftJoin('city','city.id','users.city_id')
                        ->where('users.id',Auth::user()->id)->first();
                        if($Candidatedetails->resume != null){
                            $Candidatedetails->resume = url('/assets/front_end/Upload/User_Resume/'.$Candidatedetails->resume);
                        }
                        if($Candidatedetails->coverletter != null){
                            $Candidatedetails->coverletter = url('/assets/front_end/Upload/User_Cover_Letter/'.$Candidatedetails->coverletter);
                        }
                        if($Candidatedetails->references != null){
                            $Candidatedetails->references = url('/assets/front_end/Upload/User_References/'.$Candidatedetails->references);
                        }
                if(!empty($Candidatedetails)){
                    $Userprofiledegreelevel = Userprofiledegreelevel::select('degreelevel.degreelevel','userprofile_degreelevel.*')->leftJoin('degreelevel','degreelevel.id','userprofile_degreelevel.degreelevel_id')->where('userprofile_id',Auth::user()->id)->get();
                    $Userprofilefunctionalarea = Userprofilefunctionalarea::select('userprofile_functionalarea.*','functional_area.functional_area','industries.industry_name')
                                                ->leftJoin('functional_area','functional_area.id','userprofile_functionalarea.functional_area_id')
                                                ->leftJoin('industries','industries.id','functional_area.industry_id')
                                                ->where('userprofile_functionalarea.userprofile_id',Auth::user()->id)->get();
                    $userSkill = Userprofileskilllevel::select('userprofile_skilllevel.*','careerlevel.careerlevel','jobskill.jobskill')
                                ->leftJoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                                ->leftJoin('careerlevel','careerlevel.id','userprofile_skilllevel.level_id')
                                ->where('userprofile_skilllevel.userprofile_id',Auth::user()->id)->get();
                    $json['data'] = $Candidatedetails; 
                    $json['data']['degreelevels'] = $Userprofiledegreelevel;
                    $json['data']['functionalareas'] = $Userprofilefunctionalarea;
                    $json['data']['skill'] = $userSkill;
                    $json['msg'] = "Profile Update Successfully.!";
                    return $this->respond($json);
                }else{
                    return $this->noRespondWithMessage('Candidate not found.!');    
                }
            }else{
                return $this->noRespondWithMessage('Skill or user not found.!');    
            }
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
        
    }

    public function profiledetails(Request $request){
        $validation = Validator::make($request->all(), [
            'user_id'     => 'required',
            
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        
            
        $Candidate = Candidate::select('users.*','country.country_name','state.state_name','city.city_name')
                    ->leftJoin('country','country.id','users.country_id')
                    ->leftJoin('state','state.id','users.state_id')
                    ->leftJoin('city','city.id','users.city_id')
                    ->where('users.id',$request->user_id)->first();
                    if($Candidate->resume != null){
                        $Candidate->resume = url('/assets/front_end/Upload/User_Resume/'.$Candidate->resume);
                    }
                    if($Candidate->coverletter != null){
                        $Candidate->coverletter = url('/assets/front_end/Upload/User_Cover_Letter/'.$Candidate->coverletter);
                    }
                    if($Candidate->references != null){
                        $Candidate->references = url('/assets/front_end/Upload/User_References/'.$Candidate->references);
                    }
        if(!empty($Candidate)){
            $Userprofiledegreelevel = Userprofiledegreelevel::select('degreelevel.degreelevel','userprofile_degreelevel.*')->leftJoin('degreelevel','degreelevel.id','userprofile_degreelevel.degreelevel_id')->where('userprofile_id',$request->user_id)->get();
            $Userprofilefunctionalarea = Userprofilefunctionalarea::select('userprofile_functionalarea.*','functional_area.functional_area','industries.industry_name')
                                        ->leftJoin('functional_area','functional_area.id','userprofile_functionalarea.functional_area_id')
                                        ->leftJoin('industries','industries.id','functional_area.industry_id')
                                        ->where('userprofile_functionalarea.userprofile_id',$request->user_id)->get();
            $userSkill = Userprofileskilllevel::select('userprofile_skilllevel.*','careerlevel.careerlevel','jobskill.jobskill')
                        ->leftJoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                        ->leftJoin('careerlevel','careerlevel.id','userprofile_skilllevel.level_id')
                        ->where('userprofile_skilllevel.userprofile_id',$request->user_id)->get();
            $json['data'] = $Candidate;
            $json['data']['degreelevels'] = $Userprofiledegreelevel;
            $json['data']['functionalareas'] = $Userprofilefunctionalarea;
            $json['data']['skill'] = $userSkill;
            return $this->respond($json);
        }else{
            return $this->noRespondWithMessage('User not found.!');
        }
        
    }
    
}
