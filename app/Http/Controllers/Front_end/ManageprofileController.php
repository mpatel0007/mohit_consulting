<?php

namespace App\Http\Controllers\Front_end;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appliedjobs;
use App\Models\Userprofile;
use App\Models\Industries;
use App\Models\City;
use App\Models\State;
use App\Models\Country;   
use App\Models\Jobskill;
use App\Models\Degreelevel;   
use App\Models\Billingaddress;   
use App\Models\Userprofileskilllevel;
use App\Models\Userprofilefunctionalarea;
use App\Models\Userprofiledegreelevel;
use App\Models\Careerlevel;
use App\Models\Functional_area;
use App\Models\User;
use App\Models\Companies;
use App\Models\Salary;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Hash;
use Validator;
use DataTables;
use Response;
use DB;
use Stripe;
use Symfony\Component\HttpFoundation\File\File;
use App\Helper\Helper;
use Carbon\Carbon;  


class ManageprofileController extends Controller {

    public function candidate_manage_profile_view() {
        // Helper::isSubscribed();      
        return view('Front_end/candidate/ManageProfile/appliedjobs');
    }

    public function candidate_manage_packages_view(Request $request) {
        $type = '';
        $packageID = '';
        $msg = '';
        $nextRenewalDate = '';
        $userID = Auth::guard('candidate')->id();  
        if(isset($request->msg)) {
            $msg = $request->msg;    
        }
        $lastSubscriptionsData = DB::table('subscriptions')->where('user_id',$userID)->where('stripe_status',1)->get()->toArray();
        if(!empty($lastSubscriptionsData)) {
            $packageID = $lastSubscriptionsData[0]->name;    
            $nextRenewalDate = $lastSubscriptionsData[0]->ends_at;
        }
        $data = DB::table('package')->where('status',1)->whereIn('package_for',array('0','1','2'))->get()->toArray();
        $type = 1;
        $packageFor = '';
        if($packageID>0) {
            $packageData = DB::table('package')->where('id',$packageID)->get()->toArray();    
            if(!empty($packageData)) {
                $packageFor = $packageData[0]->package_for;        
            }
        }
        return view('Front_end/candidate/ManageProfile/package')->with(compact('data','packageID','type','packageFor','msg','nextRenewalDate'));
    }    

    public function candidate_manage_payment_view($id) {    
        $data = DB::table('package')->where('id',$id)->get()->toArray();
        if(empty($data)) {
            return redirect()->route('front_end-candidate_package');
        }
        $type = '';
        if(Auth::guard('candidate')->check()) {
            $type = 1;
        } else {
            $type = 2;
        }
        $country = Country::select('id','country_name')->get();
        $BillingaddressData = Billingaddress::where('candidate_id',Auth::guard('candidate')->id())->get()->toArray(); 
        
        $state[] = '';
        $city[] = '';
        if(!empty($BillingaddressData)){
            $selected_country = $BillingaddressData[0]['country_id'];
            $selected_state = $BillingaddressData[0]['state_id'];
            $state = State::where('country_id',$selected_country)->get();
            $city = City::where('state_id',$selected_state)->get();
        }

        return view('Front_end/candidate/ManageProfile/payment')->with(compact('data','type','state','city','BillingaddressData','country'));
    }    

    public function changepassword_view(){
        return view('Front_end/candidate/ManageProfile/changepassword');
    }

    public function favouritejobs_view(){
        return view('Front_end/candidate/ManageProfile/favouritejobs');
    }

    public function candidate_document_view(){
        return view('Front_end/candidate/ManageProfile/my_document');
    }

    public function candidate_appliedjobs(Request $request){
        if ($request->ajax()) {
            $candidate_id    = Auth::guard('candidate')->id();          
            $data = DB::table('appliedjobs')
            ->select('appliedjobs.*','jobs.jobtitle as jobtitle','jobs.jobtype as jobtype','users.name as name')
            ->leftjoin("jobs", "appliedjobs.job_id", "=", "jobs.id")
            ->leftjoin("users", "appliedjobs.candidate_id",  "=", "users.id")
            ->where('appliedjobs.candidate_id',$candidate_id)
            ->get();
            
            return Datatables::of($data)
            ->addIndexColumn()

                    // ->addColumn('jobtype', function($row){  
                    //     $arrayjobtype = explode(',',$row->jobtype);
                    //     $jobtype = '';
                    //     foreach($arrayjobtype as $typeofjob){
                    //         if($typeofjob == 'fulltime'){
                    //             $jobtype .= '<nobr><span class="full-time">Full-Time</span></nobr>';
                    //         } else if ($typeofjob == 'parttime') {
                    //             $jobtype .= '<nobr><span class="part-time">Part-time</span></nobr>';
                    //         } else if ($typeofjob == 'freelance')  {
                    //             $jobtype .= '<nobr><span class="freelance">Freelance</span></nobr>';
                    //         } else if ($typeofjob == 'internship')  {
                    //             $jobtype .= '<nobr><span class="internship">Internship</span></nobr>';
                    //         } else if ($typeofjob == 'contract')  {
                    //             $jobtype .= '<nobr><span class="contract">Contract</span></nobr>';
                    //         }  
                    //      }
                    // return $jobtype;
                    // })
            ->addColumn('status', function($row){  
                if($row->status == 1){
                    $status = '<nobr><span class="full-time">Approved</span></nobr>';
                } else if ($row->status == 0) {
                    $status = '<nobr><span class="part-time">Rejected</span></nobr>';
                } else if ($row->status == 2)  {
                    $status = '<nobr><span class="freelance">Processed</span></nobr>';
                }
                return $status;
            })
            ->addColumn('created_at', function($row){
                $oldDate = $row->created_at;
                $newDate = date("F j, Y", strtotime($oldDate));  
                return $newDate;
            })
            ->addColumn('action', function($row){
                $action = "<button  class='delete_job' onclick='delete_applied_jobs(" . $row->id . ")'><i class='fa fa-trash' style='color:#21254C' aria-hidden='true'></i></button>";
                return $action;
            })
            ->rawColumns(['action','newDate','status'])
            ->make(true);
        }
    }
    public function candidate_applyjobs($job_id){
        $job_id = $job_id;
        $candidate_id   = Auth::guard('candidate')->id();
        $Appliedjobs    = new Appliedjobs();
        $find_candidate = Appliedjobs::where('candidate_id', $candidate_id)
        ->where('job_id', $job_id)
        ->get();
        $result = $find_candidate->count();
        if ($result == 0) {
            if ($candidate_id != '' && $job_id != '') {
                $Appliedjobs->candidate_id     = $candidate_id;
                $Appliedjobs->job_id           = $job_id;
                $Appliedjobs->created_at    = Carbon::now();
                $Appliedjobs->save();
                return redirect()->back()->with('success', 'Job Applied successfully');
            } 
        }else{
            return redirect()->back()->with('error', 'Already Applied this job ');
        }  
    }



    public function candidate_favouritejobs(Request $request){
        if ($request->ajax()) {
            $candidate_id    = Auth::guard('candidate')->id();          
            $data = DB::table('wishlist')
            ->select('wishlist.*','jobs.jobtitle as jobtitle','jobs.jobtype as jobtype','users.name as name')
            ->leftjoin("jobs", "wishlist.job_id", "=", "jobs.id")
            ->leftjoin("users", "wishlist.candidate_id",  "=", "users.id")
            ->where('wishlist.candidate_id',$candidate_id)
            ->get();

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('jobtitle', function($row){  
                $jobtitle =    "<a href=". route('front_end-job_details_view',['job_id' => $row->job_id]).">$row->jobtitle</a>";
                return $jobtitle;
            }) 
            ->addColumn('jobtype', function($row){  
                $arrayjobtype = explode(',',$row->jobtype);
                $jobtype = '';
                foreach($arrayjobtype as $typeofjob){
                    if($typeofjob == 'fulltime'){
                        $jobtype .= '<nobr><span class="full-time">Full-Time</span></nobr>';
                    } else if ($typeofjob == 'parttime') {
                        $jobtype .= '<nobr><span class="part-time">Part-time</span></nobr>';
                    } else if ($typeofjob == 'freelance')  {
                        $jobtype .= '<nobr><span class="freelance">Freelance</span></nobr>';
                    } else if ($typeofjob == 'internship')  {
                        $jobtype .= '<nobr><span class="internship">Internship</span></nobr>';
                    } else if ($typeofjob == 'contract')  {
                        $jobtype .= '<nobr><span class="contract">Contract</span></nobr>';
                    }  
                }
                return $jobtype;
            })
            ->addColumn('ApplyNow', function($row){
                $find_candidate = Appliedjobs::where('candidate_id', Auth::guard('candidate')->id())
                ->where('job_id', $row->job_id)
                ->first();
                if($find_candidate == '' && $find_candidate == null){
                    $button_text = 'Apply Now';
                }else{
                    $button_text = 'Applied';
                }
                if(Auth::guard('candidate')->check()){
                    $ApplyNow = '<a href='. route('front_end-apply-jobs', ['job_id' => $row->job_id]).' class=" btn full-time btn-sm">'.$button_text.'</a>';
                }else{
                    $ApplyNow =  '<a href='. route('front_end-signup') .' class=" btn full-time btn-sm">Apply Now</a>';
                }
                return $ApplyNow;
            })
            ->rawColumns(['ApplyNow','jobtype','jobtitle'])
            ->make(true);
        }
    }

    public function delete_appliedjobs(Request $request){
        $delete_id = $request->id;
        $result['status'] = 0;
        $result['msg'] = "Oops ! Applied jobs Data Not Deleted !";
        if(!empty($delete_id)){
            $del_sql = Appliedjobs::where('id',$delete_id)->delete();
            if($del_sql){
                $result['status'] = 1;
                $result['msg'] = "Applied Jobs Data Deleted Successfully";
            }
        }
        echo json_encode($result);
        exit;
    }
// ____________________________________________resume________________________________________________

    public function candidate_document_upload_resume(Request $request){

        $result['status'] = 0;
        $result['msg'] = "Resume not Uploaded !";
        $request->validate([
            'upload_resume'     => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);
        $Resume_name = time().'.'.$request->upload_resume->extension();  
        $request->upload_resume->move(public_path('assets/front_end/Upload/User_Resume'), $Resume_name);
        if(!empty($Resume_name)){
            $candidate_id = Auth::guard('candidate')->id();
            $Userprofile = Userprofile::where('id', $candidate_id)->first();
            $resume = public_path('assets/front_end/Upload/User_Resume/'.$Userprofile->resume);
            if($Userprofile->resume != '' && $Userprofile->resume != null && file_exists($resume)){
                unlink($resume);
            }
            $Userprofile->resume       = $Resume_name;
            $Userprofile->updated_at   = Carbon::now();
            $Userprofile->save();
            $result['status'] = 1;
            $result['msg'] = "Resume Uploaded !";
        }
        echo json_encode($result);
        exit;
    }
    
    public function candidate_document_dowload_resume() {
        $candidate_id = Auth::guard('candidate')->id();
        $Userprofile = Userprofile::where('id', $candidate_id)->first();
        if($Userprofile->resume != '' & $Userprofile->resume != ''){
            $file = public_path('assets/front_end/Upload/User_Resume/'.$Userprofile->resume.'');
            if($file != '' & $file != '' && file_exists($file)){
                return Response::download($file);  
            }else{
                return back()->with('error','Error !! Document not uploaded.');
            }
        }else{
            return back()->with('error','Error !! Document not uploaded.');
        }
    }
// __________________________________________coverletter__________________________________________________
    public function candidate_document_upload_coverletter(Request $request){
        $result['status'] = 0;
        $result['msg'] = "Oops ! Cover Letter  not Uploaded !";
        $request->validate([
            'cover_letter'     => 'required|mimes:pdf,doc,docx|max:2048',
        ]);
        $coverletter_name = time().'.'.$request->cover_letter->extension();  
        $request->cover_letter->move(public_path('assets/front_end/Upload/User_Cover_Letter'), $coverletter_name);
        if(!empty($coverletter_name)){
            $candidate_id = Auth::guard('candidate')->id();
            $Userprofile = Userprofile::where('id', $candidate_id)->first();
            $coverletter = public_path('assets/front_end/Upload/User_Cover_Letter/'.$Userprofile->coverletter);
            if($Userprofile->coverletter != '' && $Userprofile->coverletter != null && file_exists($coverletter)){
                unlink($coverletter);
            }
            $Userprofile->coverletter  = $coverletter_name;
            $Userprofile->updated_at   = Carbon::now();
            $Userprofile->save();
            $result['status'] = 1;
            $result['msg'] = " Cover Letter  Uploaded !";
        }
        echo json_encode($result);
        exit;

    }
    
    public function candidate_document_dowload_coverletter(){
        $candidate_id = Auth::guard('candidate')->id();
        $Userprofile = Userprofile::where('id', $candidate_id)->first();
        if($Userprofile->coverletter != '' & $Userprofile->coverletter != ''){
            $file = public_path('assets/front_end/Upload/User_Cover_Letter/'.$Userprofile->coverletter.'');
            if($file != '' & $file != '' && file_exists($file)){
                return Response::download($file);
            }else{
                return back()->with('error','Error !! Document not uploaded.');
            }
        }else{
            return back()->with('error','Error !! Document not uploaded.');
        }
    }
// _________________________________________references___________________________________________________

    public function candidate_document_upload_references(Request $request){
        $result['status'] = 0;
        $result['msg'] = "References Not Uploaded !";
        $request->validate([
            'upload_references'     => 'required|mimes:pdf,doc,docx|max:2048',
        ]);
        $References_name = time().'.'.$request->upload_references->extension();  
        $request->upload_references->move(public_path('assets/front_end/Upload/User_References'), $References_name);
        if(!empty($References_name)){
            $candidate_id = Auth::guard('candidate')->id();
            $Userprofile = Userprofile::where('id', $candidate_id)->first();
            $References = public_path('assets/front_end/Upload/User_References/'.$Userprofile->references);
            if($Userprofile->references != '' && $Userprofile->references != null && file_exists($References)){
                unlink($References);
            }
            $Userprofile->references   = $References_name;
            $Userprofile->updated_at   = Carbon::now();
            $Userprofile->save();
            $result['status'] = 1;
            $result['msg'] = "References Uploaded !";
        }
        echo json_encode($result);
        exit;
    }

    public function candidate_document_dowload_references(){
        $candidate_id = Auth::guard('candidate')->id();
        $Userprofile = Userprofile::where('id', $candidate_id)->first();
        if($Userprofile->references != '' & $Userprofile->references != ''){
            $file = public_path('assets/front_end/Upload/User_References/'.$Userprofile->references.'');
            if($file != '' & $file != '' && file_exists($file)){
                return Response::download($file);
            }else{
                return back()->with('error','Error !! Document not uploaded.');
            }
        }else{
            return back()->with('error','Error !! Document not uploaded.');
        }
    }

// ____________________________________________________________________________________________

    public function changepassword_proccess(Request $request){
        $this->validate($request, [
            'oldpassword'       => 'required|',
            'password'          => 'required|min:6|max:20',
            'confirm_password'    => 'required|min:6|max:20|same:password',
        ]);
        $PasswordData = $request->all();
        $user_id   = Auth::guard('candidate')->id();
        $find_user = Userprofile::where('id', '=', $user_id)->first();    
        if(Hash::check($PasswordData['oldpassword'], $find_user->password)){    
            if(!empty($find_user)){
                $find_user->password     =  Hash::make($PasswordData['password']);
                $find_user->updated_at   = Carbon::now();
                $find_user->save();
                return redirect()->back()->with('success', 'Your Password Change Successfully');
            } else {
                return redirect()->back()->with('error', 'User does not exist Regiser First!');
            }
        }else{
            return redirect()->back()->with('error', 'The old password you have entered is incorrect');
        }
    }

    public function candidate_profile_image(Request $request){
        $result['status'] = 0;
        $result['msg'] = "Oops ! Profile Image not updated !";

        $validation = Validator::make($request->all(), [
            // 'croppedImageDataURL'             => 'required|max:2192',     
            'croppedImageDataURL'             => 'required',     
        ]);
        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }
        $candidate_id = Auth::guard('candidate')->id();
        $Userprofile = Userprofile::where('id',$candidate_id)->first();
        $Userprofile->profileimg = $request->croppedImageDataURL;
        $Userprofile->save();
        if($Userprofile){
            $result['status'] = 1;
            $result['msg'] = "Profile Image updated Successfully !";
        }
        echo json_encode($result);
        exit;
    }

    public function change_profile_view(Request $request){
        $candidate_id = Auth::guard('candidate')->id();
        if (!empty($candidate_id)) {
            $find_userProfile = Userprofile::where('id', $candidate_id)->first();
            if (!empty($find_userProfile)) {
                $Userprofiledegreelevel = Userprofiledegreelevel::where('userprofile_id',$candidate_id)->get();
                $Filldegreelevel_id = array();
                foreach($Userprofiledegreelevel as $degreelevel_id)
                {
                    $Filldegreelevel_id[] =  $degreelevel_id['degreelevel_id'];
                }
                $Userprofilefunctionalarea = Userprofilefunctionalarea::where('userprofile_id',$candidate_id)->get()->toArray();
                $Userprofilefunctionalarea_id = array();
                foreach($Userprofilefunctionalarea as $functionalarea_id)
                {
                    $Userprofilefunctionalarea_id[] =  $functionalarea_id['functional_area_id'];
                }

                $getSkill = Userprofileskilllevel::where('userprofile_id',$candidate_id)->get();
                $Fillskill_id = array();
                $Filllevel_id = array();
                $count = 0;
                foreach($getSkill as $skill_id)
                {
                    $Fillskill_id[] = $skill_id['skill_id'];
                    $Filllevel_id[] = $skill_id['level_id'];
                    $count = count($Filllevel_id);
                }
                $Userprofile_edit_data = $find_userProfile;
                $industry = Industries::select('id', 'industry_name')->get();
                $country = Country::select('id', 'country_name')->get();
                $selected_country = $Userprofile_edit_data->country_id;
                $selected_state = $Userprofile_edit_data->state_id;
                $state = State::where('country_id', $selected_country)->get();
                $degreelevel =  Degreelevel::select('id','degreelevel')->get();
                $jobskill =  Jobskill::select('id','jobskill')->get();
                $city = City::where('state_id', $selected_state)->get();
                $career =  Careerlevel::select('id','careerlevel')->get();
                
                // $subCategories = Functional_area::where('industry_id',$Userprofile_edit_data->industry_id)->get();
                $subCategories  = Functional_area::where('industry_id',isset($Userprofile_edit_data->industry_id) ? $Userprofile_edit_data->industry_id : '')->get();
                $salaries =  Salary::select('id','salary')->get();

                return view('Front_end/candidate/ManageProfile/changeprofile')->with(compact('Userprofile_edit_data','Userprofilefunctionalarea_id','count','subCategories','degreelevel','Fillskill_id','Filllevel_id','Filldegreelevel_id','career','jobskill','industry', 'city', 'state', 'country','salaries'));
            }
        }
    }

    public function getSkillLevel(){
        $jobskill =  Jobskill::select('id','jobskill')->get();
        $career =  Careerlevel::select('id','careerlevel')->get();
        $skill = array();
        $career_level = array();
        if (!empty($jobskill)) {
            foreach ($jobskill as $explodeKey => $explodeValue) {
                $skill[$explodeValue->id] = $explodeValue->jobskill;
            }
        }
        if (!empty($career)) {
            foreach ($career as $explodeKey => $careerValue) {
                $career_level[$careerValue->id] = $careerValue->careerlevel;
            }
        }
        $data['skills'] = $skill;
        $data['career'] = $career_level;
        echo json_encode($data);
        exit;
    }

    public function changeprofile_proccess(Request $request){

        $validation = Validator::make($request->all(), [
            'fname'             => 'required',
            'lname'             => 'required',
            'dob'               => 'required',
            // 'gender'         => 'required',
            'country'           => 'required',
            'state'             => 'required',
            'city'              => 'required',
            'experience'        => 'required',
            'career'            => 'required',
            'industry'          => 'required',
            'subCategory'        => 'required',            
            'profileimg'        => 'mimes:jpeg,jpg,png,gif',
            
        ]);
        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }
        // $image = $request->file('profileimg');
        // if (!empty($image)) {
        //     $image_name = time() . '.' . $image->getClientOriginalExtension();
        //     $destinationPath = public_path('assets/admin/userprofileImg/');
        //     $image_resize = Image::make($image->getRealPath());
        //     $image_resize->resize(300, 200);
        //     if (!empty($image_name)) {
        //         $image_resize->save($destinationPath . $image_name, 80);
        //     }
        // }
        $result['status'] = 0;
        $result['msg'] = "Please enter valid data";
        $UserprofileData = $request->all();
        $candidate_id = Auth::guard('candidate')->id();
        $UpdateDetails = Userprofile::where('id', $candidate_id)->first();
        // $UpdateDetails->profileimg         = !empty($image_name) ? $image_name : $UpdateDetails->profileimg;
        $UpdateDetails->name               = $UserprofileData['fname'];
        $UpdateDetails->mname              = $UserprofileData['mname'];
        $UpdateDetails->lname              = $UserprofileData['lname'];
        $UpdateDetails->dateofbirth        = $UserprofileData['dob'];
        // $UpdateDetails->gender             = $UserprofileData['gender'];
        // $UpdateDetails->maritalstatus      = $UserprofileData['marital'];
        $UpdateDetails->country_id         = $UserprofileData['country'];
        $UpdateDetails->state_id           = $UserprofileData['state'];
        $UpdateDetails->city_id            = $UserprofileData['city'];
        // $UpdateDetails->phone              = $UserprofileData['phone'];
        $UpdateDetails->mobile             = $UserprofileData['mobile'];
        $UpdateDetails->experience         = $UserprofileData['experience'];
        $UpdateDetails->jobskill_id         = $UserprofileData['jobskill'];
        $UpdateDetails->careerlevel        = $UserprofileData['career'];
        $UpdateDetails->industry_id        = $UserprofileData['industry'];
        // $UpdateDetails->functional_id      = $UserprofileData['functional'];
        $UpdateDetails->currentsalary      = $UserprofileData['csalary'];
        $UpdateDetails->expectedsalary     = $UserprofileData['esalary'];
        $UpdateDetails->streetaddress      = $UserprofileData['strretaddress'];
        //$UpdateDetails->userstatus         = $UserprofileData['status'];
        $UpdateDetails->updated_at = Carbon::now();
        $UpdateDetails->save();
        $result['status'] = 1;
        $result['msg'] = "Candidate Details Updated Successfully";
        if($candidate_id != '' && $candidate_id != null){
            $del_Userprofiledegreelevel  = Userprofiledegreelevel::where('userprofile_id',$candidate_id)->delete();
            $del_Userprofileskilllevel  = Userprofileskilllevel::where('userprofile_id',$candidate_id)->delete();
            $del_Userprofilefunctionalarea  = Userprofilefunctionalarea::where('userprofile_id',$candidate_id)->delete();


            $allDegreelevel =  $UserprofileData['degreelevel'];
            if($allDegreelevel != '' && $allDegreelevel != null ){
                foreach ($allDegreelevel as $key => $Degreelevel_id) {
                    $Userprofiledegreelevel = new Userprofiledegreelevel();   
                    $Userprofiledegreelevel->userprofile_id      = $candidate_id;
                    $Userprofiledegreelevel->degreelevel_id      = $Degreelevel_id;
                    $Userprofiledegreelevel->created_at    = Carbon::now();
                    $Userprofiledegreelevel->save();
                }
            }
            $Userprofile_functionalarea =  $UserprofileData['subCategory'];
            if($Userprofile_functionalarea != '' && $Userprofile_functionalarea != null ){
                foreach ($Userprofile_functionalarea as $key => $functional_area_id) {
                    $Userprofilefunctionalarea = new Userprofilefunctionalarea();   
                    $Userprofilefunctionalarea->userprofile_id          = $candidate_id;
                    $Userprofilefunctionalarea->functional_area_id      = $functional_area_id;
                    $Userprofilefunctionalarea->functional_area_id      = $functional_area_id;
                    $Userprofilefunctionalarea->updated_at = Carbon::now();
                    $Userprofilefunctionalarea->save();
                }
            }
            if(isset($UserprofileData['skill']) && isset($UserprofileData['level'])){
                $skill_ids = $UserprofileData['skill']; 
                $level_ids = $UserprofileData['level'];                
                if($skill_ids != "" && $level_ids != ""){
                    foreach ($skill_ids as $key => $skill_id) {
                        $Userprofileskilllevel = new Userprofileskilllevel();   
                        $Userprofileskilllevel->userprofile_id        = $candidate_id;
                        $Userprofileskilllevel->skill_id              = $skill_id;
                        $Userprofileskilllevel->level_id              = $level_ids[$key];
                        $Userprofileskilllevel->updated_at = Carbon::now();
                        $Userprofileskilllevel->save();
                    }
                }else{
                    $result['status'] = 0;
                    $result['msg'] = "Select Job skill and career level";
                }
            }
        }
        echo json_encode($result);
        exit;
    }

    public function payment(Request $request) {
        return view('Front_end/candidate/ManageProfile/payment');
    }     
    
    public function teamup_list_view(Request $request) {
        return view('Front_end/candidate/ManageProfile/teamup_list');
    }   

    public function dopayment(Request $request) {
        $this->validate($request, [  
            'address'             => 'required',
            'country'             => 'required',
            'state'               => 'required',
            'city'                => 'required',
            'stripeToken'         => 'required', 
            'packageId'           => 'required',
            'cardName'            => 'required',
            'cardNum'             => 'required',
            'packageId'           => 'required',
        ]);  
        try {
            $insertdata = $request->all();
            $id =  $request->packageId;       
            $cardName = $request->cardName;
            $data = DB::table('package')->where('id',$id)->get()->toArray();
            $BillingaddressData = Billingaddress::where('candidate_id',Auth::guard('candidate')->id())->get()->toArray(); 
            if(empty($BillingaddressData)){
                $Billingaddress = new Billingaddress;
                $Billingaddress->address       = $insertdata['address'];
                $Billingaddress->candidate_id  = Auth::guard('candidate')->id();
                $Billingaddress->country_id    = $insertdata['country'];
                $Billingaddress->state_id      = $insertdata['state'];
                $Billingaddress->city_id       = $insertdata['city'];
                $Billingaddress->save();
            }else{
                $BillingaddressUpdate = Billingaddress::where('candidate_id',Auth::guard('candidate')->id())->first(); 
                $BillingaddressUpdate->address       = $insertdata['address'];
                $BillingaddressUpdate->candidate_id  = Auth::guard('candidate')->id();
                $BillingaddressUpdate->country_id    = $insertdata['country'];
                $BillingaddressUpdate->state_id      = $insertdata['state'];
                $BillingaddressUpdate->city_id       = $insertdata['city'];
                $BillingaddressUpdate->save();
            }
            if(empty($data)) {
                return redirect()->route('front_end-candidate_package');
            }  

            $isCandidate = 1;
            $userID = Auth::guard('candidate')->id();
            $userData = Auth::guard('candidate')->user();
            $email = $userData->email;
            if(!empty($userData) && $userData->is_company == '1') {
                $isCandidate = 0;
            }
            $packageData = DB::table('package')->where('id',$id)->get()->toArray();
            $packageFor = '';
            $packagePrice = 0;
            if(!empty($packageData)) {
                $packageFor = $packageData[0]->package_for;
                $packagePrice = $packageData[0]->package_price;
            }    

            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $address = $insertdata['address'];
            $country = '';
            $state = '';
            $city = '';
            $customer = Helper::createCustomer($cardName,$email,$request->stripeToken,$address,$country,$state,$city);
            $lastSubscriptionsData = DB::table('subscriptions')->where('user_id',$userID)->where('stripe_status',1)->get()->toArray();   

            $lastEndDate = '';
            $currentDate = date("Y-m-d");
            if(!empty($lastSubscriptionsData)) {
                $lastEndDate = $lastSubscriptionsData[0]->ends_at;
            } else {
                if($packageFor == '0') {
                    /*DB::table('companies')->insert([
                        'user_id' => $userID
                    ]);*/            
                }
            }

            if(!empty($customer) && isset($customer->id)) { 
                $chargeData = array();
                if($lastEndDate == '') {
                    $chargeData = Helper::chargeCustomer($packagePrice,$customer->id,$userID);    
                    $subscriptionStartDate = date("Y-m-d");
                    $subscriptionEndDate = date("Y-m-d",strtotime("+29 days"));
                } else if($currentDate>$lastEndDate) {
                    $chargeData = Helper::chargeCustomer($packagePrice,$customer->id,$userID);    
                    $subscriptionStartDate = date("Y-m-d");
                    $subscriptionEndDate = date("Y-m-d",strtotime("+29 days"));
                } else {
                    $chargeData = 1;
                    $subscriptionStartDate = date("Y-m-d",strtotime($lastEndDate."+1 day"));
                    $subscriptionEndDate = date("Y-m-d",strtotime($subscriptionStartDate."+29 days"));
                }
                DB::table('subscriptions')->update([
                    'is_downgraded'=>1,
                    'stripe_status' => '0' 
                ],array('user_id'=>$userID)); 
                

                if( (!empty($chargeData) && isset($chargeData->id)) || $chargeData == '1' ) {  
                    $number =  $request->cardNum;
                    $masked =  str_pad(substr($number, -4), strlen($number), '*', STR_PAD_LEFT);

                    $mytime = Carbon::now();
                    DB::table('credit_card')->insert([
                        'user_id' => $userID,
                        'subscription_id'=>$customer->id,
                        'credit_card'=>$masked,
                        'created_at'=>$mytime,
                        'customer_id'=>$customer->id
                    ]);  

                    $mytime = Carbon::now();

                    if($packageFor == '0') {
                        DB::table('subscriptions')->insert([
                            'user_id' => $userID,
                            'stripe_id' =>$customer->id,
                            'stripe_price'=>$packagePrice,
                            'quantity' => '1',
                            'name'=> $id,
                            'stripe_status'=>1,
                            'candidate'=>0,        
                            'start_at'=>$subscriptionStartDate,
                            'ends_at'=>$subscriptionEndDate,
                            'created_at'=>$mytime
                        ]);
                    } else {
                        DB::table('subscriptions')->insert([
                            'user_id' => $userID,
                            'stripe_id' =>$customer->id,
                            'stripe_price'=>$packagePrice,  
                            'quantity' => '1',
                            'name'=> $id,
                            'stripe_status'=>1,
                            'candidate'=>1,        
                            'start_at'=>$subscriptionStartDate,
                            'ends_at'=>$subscriptionEndDate,
                            'created_at'=>$mytime
                        ]);
                    }

                    if($packageFor == '0') {
                        User::where('id', $userID)->update(array('is_company'=>'1'));
                    } else {
                        User::where('id', $userID)->update(array('is_company'=>'0'));
                    }

                    if(Auth::guard('candidate')->check()) {
                        return redirect()->route('front_end-candidate_package')->with('success', 'You have successfully subscribed package');  
                    } else {    
                        return redirect()->route('front-end-employers_payment')->with('success', 'You have successfully subscribed package');  
                    }    
                }
            } else {
                return redirect()->back()->with('error', 'Something went wrong');
            }
        } catch (\Exception $e) {
            // echo json_encode(array('status'=>0,'msg'=>$e->getMessage()));
            return redirect()->back()->with('error', $e->getMessage());

        }
    }
    
    public function downgradePackage(Request $request) {
        try {
            if ($request->ajax()) {
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $userID = Auth::guard('candidate')->id();  
                $subscriptionsData = DB::table('subscriptions')->where('user_id',$userID)->where('stripe_status',1)->get()->toArray();    
                $currentPackageID = 0;      
                if(!empty($subscriptionsData)) {
                    $currentPackageID = $subscriptionsData[0]->name;    
                }
                if($currentPackageID >0) {
                    DB::table('subscriptions')->update([
                        'is_downgraded'=>1,
                        'stripe_status' => '0' 
                    ],array('user_id'=>$userID));      
                } 
                echo json_encode(array('status'=>1));
            }
        } catch (\Exception $e) {
            // echo json_encode(array('status'=>0,'msg'=>$e->getMessage()));
            return redirect()->back()->with('error', $e->getMessage());

        }

    }

    public function candidate_chat_view() {  
        return view('Front_end/candidate/ManageProfile/chat'); 
    }
}
