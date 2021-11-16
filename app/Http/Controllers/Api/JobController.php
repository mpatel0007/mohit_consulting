<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Appliedjobs;
use App\Models\Jobs;
use App\Models\Wishlist;
use Carbon\Carbon;
use DB;
use App\Models\Jobskilllevel;
use App\Models\Jobdegreelevel;
use App\Models\Jobcity;
use App\Models\Jobfunctionalarea;

class JobController extends APIController
{
    public function list(Request $request){
        if (Auth::check()) {
        $Jobs = DB::table('jobs')
                    ->select('jobs.*',DB::raw('group_concat(functional_area.functional_area) as functional_area'),'salary.salary','companies.location','companies.companyname','companies.companylogo','companies.companydetail','companies.facebook','companies.twitter','companies.linkedin','country.country_name','state.state_name','industries.industry_name as category','wishlist.id as wishlist_id','appliedjobs.status as job_status')
                    ->leftjoin('industries', 'industries.id', '=', 'jobs.industry_id')
                    ->leftjoin('companies', 'companies.user_id', '=', 'jobs.company_id')
                    ->leftjoin('salary', 'salary.id', '=', 'jobs.salaryfrom')
                    ->leftjoin('country', 'country.id', '=', 'jobs.country_id')
                    ->leftjoin('state', 'state.id', '=', 'jobs.state_id')
                    ->leftjoin('Job_functionalarea', 'Job_functionalarea.job_id', '=', 'jobs.id')
                    ->leftjoin('functional_area', 'functional_area.id', '=', 'Job_functionalarea.functional_area_id')
                    ->where('jobs.status','1');
                    if($request->title){
                        $Jobs->where('jobs.jobtitle','like','%' . $request->title . '%');
                    }
                    if($request->category_id){
                        $Jobs->where('jobs.industry_id',$request->category_id);
                    }
            $Jobs->leftjoin('wishlist', function($join){
                $join->on('jobs.id','=', "wishlist.job_id");
                $join->where("wishlist.candidate_id" , Auth::user()->id);
            });
            $Jobs->leftjoin('appliedjobs', function($join){
                $join->on('jobs.id','=', "appliedjobs.job_id");
                $join->where("appliedjobs.candidate_id" , Auth::user()->id);
            });
            $Jobs->groupBy('jobs.id');
            $Jobs = $Jobs->paginate(5);


        return $this->respond($Jobs);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
    public function apply_job(Request $request){


        $validation = Validator::make($request->all(), [
            'job_id'=>'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            $user_role = $request->user()->token()->name;
            if($user_role != 'Candidate_token'){
                return $this->noRespondWithMessage('Only Candidate allow to apply job');
            }
            $get_apply_count = Appliedjobs::where('candidate_id', $request->user()->id)
            ->where('job_id', $request->job_id)
            ->count();
            if($get_apply_count > 0){
                return $this->noRespondWithMessage('You have already apply on this job.');
            }
            $Appliedjobs    = new Appliedjobs();
            $Appliedjobs->candidate_id     = $request->user()->id;
            $Appliedjobs->job_id           = $request->job_id;
            $Appliedjobs->save();
            $json['status'] = 1;
            $json['msg'] = "Job Apply Successfully";
                $Jobs = DB::table('jobs')
                            ->select('jobs.*',DB::raw('group_concat(functional_area.functional_area) as functional_area'),'salary.salary','companies.location','companies.companyname','companies.companylogo','companies.companydetail','companies.facebook','companies.twitter','companies.linkedin','country.country_name','state.state_name','industries.industry_name as category','wishlist.id as wishlist_id','appliedjobs.status as job_status')
                            ->leftjoin('industries', 'industries.id', '=', 'jobs.industry_id')
                            ->leftjoin('companies', 'companies.user_id', '=', 'jobs.company_id')
                            ->leftjoin('salary', 'salary.id', '=', 'jobs.salaryfrom')
                            ->leftjoin('country', 'country.id', '=', 'jobs.country_id')
                            ->leftjoin('state', 'state.id', '=', 'jobs.state_id')
                            ->leftjoin('Job_functionalarea', 'Job_functionalarea.job_id', '=', 'jobs.id')
                            ->leftjoin('functional_area', 'functional_area.id', '=', 'Job_functionalarea.functional_area_id')
                            ->where('jobs.id', $request->job_id);

            $Jobs->leftjoin('wishlist', function($join){
                $join->on('jobs.id','=', "wishlist.job_id");
                $join->where("wishlist.candidate_id" , Auth::user()->id);
            });
            $Jobs->leftjoin('appliedjobs', function($join){
                $join->on('jobs.id','=', "appliedjobs.job_id");
                $join->where("appliedjobs.candidate_id" , Auth::user()->id);
            });
            $json['data'] = $Jobs->first();
            //$json['data'] = $Appliedjobs;

            return $this->respond($json);
        }else {
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
    public function apply_job_remove(Request $request){


        $validation = Validator::make($request->all(), [
            'job_id'=>'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            $user_role = $request->user()->token()->name;
            if($user_role != 'Candidate_token'){
                return $this->noRespondWithMessage('Only Candidate allow to apply job');
            }
            $get_apply_count = Appliedjobs::where('candidate_id', $request->user()->id)
            ->where('job_id', $request->job_id)
            ->count();
            if($get_apply_count > 0){
                Appliedjobs::where('candidate_id', $request->user()->id)
                ->where('job_id', $request->job_id)->delete();
                
            }else{
                return $this->noRespondWithMessage('You have not apply on this job.');
            }
            $json['status'] = 1;
            $json['msg'] = "Job Apply remove Successfully";
            $Jobs = DB::table('jobs')
                    ->select('jobs.*',DB::raw('group_concat(functional_area.functional_area) as functional_area'),'salary.salary','companies.location','companies.companyname','companies.companylogo','companies.companydetail','companies.facebook','companies.twitter','companies.linkedin','country.country_name','state.state_name','industries.industry_name as category','wishlist.id as wishlist_id','appliedjobs.status as job_status')
                    ->leftjoin('industries', 'industries.id', '=', 'jobs.industry_id')
                    ->leftjoin('companies', 'companies.user_id', '=', 'jobs.company_id')
                    ->leftjoin('salary', 'salary.id', '=', 'jobs.salaryfrom')
                    ->leftjoin('country', 'country.id', '=', 'jobs.country_id')
                    ->leftjoin('state', 'state.id', '=', 'jobs.state_id')
                    ->leftjoin('Job_functionalarea', 'Job_functionalarea.job_id', '=', 'jobs.id')
                    ->leftjoin('functional_area', 'functional_area.id', '=', 'Job_functionalarea.functional_area_id')
                    ->where('jobs.id', $request->job_id);

            $Jobs->leftjoin('wishlist', function($join){
                $join->on('jobs.id','=', "wishlist.job_id");
                $join->where("wishlist.candidate_id" , Auth::user()->id);
            });
            $Jobs->leftjoin('appliedjobs', function($join){
                $join->on('jobs.id','=', "appliedjobs.job_id");
                $join->where("appliedjobs.candidate_id" , Auth::user()->id);
            });
            $json['data'] = $Jobs->first();
            //$json['data'] = $Appliedjobs;

            return $this->respond($json);
        }else {
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
    public function wishlist(Request $request){


        $validation = Validator::make($request->all(), [
            'job_id'=>'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            $user_role = $request->user()->token()->name;
            if($user_role != 'Candidate_token'){
                return $this->noRespondWithMessage('Only Candidate allow');
            }
            $wishlist = Wishlist::where('candidate_id', $request->user()->id)
            ->where('job_id', $request->job_id)
            ->first();
            if (!empty($wishlist)) {
                $wishlist->delete();
                $json['status'] = 1;
                $json['message'] = "Remove from wishlist.";
                $Jobs = DB::table('jobs')
                    ->select('jobs.*',DB::raw('group_concat(functional_area.functional_area) as functional_area'),'salary.salary','companies.location','companies.companyname','companies.companylogo','companies.companydetail','companies.facebook','companies.twitter','companies.linkedin','country.country_name','state.state_name','industries.industry_name as category','wishlist.id as wishlist_id','appliedjobs.status as job_status')
                    ->leftjoin('industries', 'industries.id', '=', 'jobs.industry_id')
                    ->leftjoin('companies', 'companies.user_id', '=', 'jobs.company_id')
                    ->leftjoin('salary', 'salary.id', '=', 'jobs.salaryfrom')
                    ->leftjoin('country', 'country.id', '=', 'jobs.country_id')
                    ->leftjoin('state', 'state.id', '=', 'jobs.state_id')
                    ->leftjoin('Job_functionalarea', 'Job_functionalarea.job_id', '=', 'jobs.id')
                    ->leftjoin('functional_area', 'functional_area.id', '=', 'Job_functionalarea.functional_area_id')
                    ->where('jobs.id', $request->job_id);

            $Jobs->leftjoin('wishlist', function($join){
                $join->on('jobs.id','=', "wishlist.job_id");
                $join->where("wishlist.candidate_id" , Auth::user()->id);
            });
            $Jobs->leftjoin('appliedjobs', function($join){
                $join->on('jobs.id','=', "appliedjobs.job_id");
                $join->where("appliedjobs.candidate_id" , Auth::user()->id);
            });
            $json['data'] = $Jobs->first();
                return $this->respond($json);
            }else{
                $wishlist = new Wishlist;
                $wishlist->job_id = $request->job_id;
                $wishlist->candidate_id = $request->user()->id;
                $wishlist->save();
                $json['status'] = 1;
                $json['message'] = "Add to wishlist.";

                $Jobs = DB::table('jobs')
                    ->select('jobs.*',DB::raw('group_concat(functional_area.functional_area) as functional_area'),'salary.salary','companies.location','companies.companyname','companies.companylogo','companies.companydetail','companies.facebook','companies.twitter','companies.linkedin','country.country_name','state.state_name','industries.industry_name as category','wishlist.id as wishlist_id','appliedjobs.status as job_status')
                    ->leftjoin('industries', 'industries.id', '=', 'jobs.industry_id')
                    ->leftjoin('companies', 'companies.user_id', '=', 'jobs.company_id')
                    ->leftjoin('salary', 'salary.id', '=', 'jobs.salaryfrom')
                    ->leftjoin('country', 'country.id', '=', 'jobs.country_id')
                    ->leftjoin('state', 'state.id', '=', 'jobs.state_id')
                    ->leftjoin('Job_functionalarea', 'Job_functionalarea.job_id', '=', 'jobs.id')
                    ->leftjoin('functional_area', 'functional_area.id', '=', 'Job_functionalarea.functional_area_id')
                    ->where('jobs.id', $request->job_id);

            $Jobs->leftjoin('wishlist', function($join){
                $join->on('jobs.id','=', "wishlist.job_id");
                $join->where("wishlist.candidate_id" , Auth::user()->id);
            });
            $Jobs->leftjoin('appliedjobs', function($join){
                $join->on('jobs.id','=', "appliedjobs.job_id");
                $join->where("appliedjobs.candidate_id" , Auth::user()->id);
            });
            $json['data'] = $Jobs->first();
                return $this->respond($json);
            }
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }

    }
    public function favlist(Request $request){
        if (Auth::check()) {
        $Jobs = DB::table('wishlist')
                    ->select('jobs.*',DB::raw('group_concat(functional_area.functional_area) as functional_area'),'salary.salary','companies.location','companies.companyname','companies.companylogo','companies.companydetail','companies.facebook','companies.twitter','companies.linkedin','country.country_name','state.state_name','industries.industry_name as category','wishlist.id as wishlist_id','appliedjobs.status as job_status')
                    ->join('jobs', 'jobs.id', '=', 'wishlist.job_id')
                    ->leftjoin('industries', 'industries.id', '=', 'jobs.industry_id')
                    ->leftjoin('companies', 'companies.user_id', '=', 'jobs.company_id')
                    ->leftjoin('salary', 'salary.id', '=', 'jobs.salaryfrom')
                    ->leftjoin('country', 'country.id', '=', 'jobs.country_id')
                    ->leftjoin('state', 'state.id', '=', 'jobs.state_id')
                    ->leftjoin('Job_functionalarea', 'Job_functionalarea.job_id', '=', 'jobs.id')
                    ->leftjoin('functional_area', 'functional_area.id', '=', 'Job_functionalarea.functional_area_id')
                    ->where('jobs.status','1');
                    if($request->title){
                        $Jobs->where('jobs.jobtitle','like','%' . $request->title . '%');
                    }
                    if($request->category_id){
                        $Jobs->where('jobs.industry_id',$request->category_id);
                    }

                    $Jobs->leftjoin('appliedjobs', function($join){
                        $join->on('jobs.id','=', "appliedjobs.job_id");
                        $join->where("appliedjobs.candidate_id" , Auth::user()->id);
                    });
                    $Jobs->where('wishlist.candidate_id',Auth::user()->id);
                    $Jobs->groupBy('jobs.id');
                    $Jobs = $Jobs->paginate(5);

            return $this->respond($Jobs);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
    public function appliedlist(Request $request){
        if (Auth::check()) {
        $Jobs = DB::table('appliedjobs')
        ->select('jobs.*',DB::raw('group_concat(functional_area.functional_area) as functional_area'),'salary.salary','companies.location','companies.companyname','companies.companylogo','companies.companydetail','companies.facebook','companies.twitter','companies.linkedin','country.country_name','state.state_name','industries.industry_name as category','wishlist.id as wishlist_id','appliedjobs.status as job_status')
                    ->join('jobs', 'jobs.id', '=', 'appliedjobs.job_id')
                    ->leftjoin('industries', 'industries.id', '=', 'jobs.industry_id')
                    ->leftjoin('companies', 'companies.user_id', '=', 'jobs.company_id')
                    ->leftjoin('salary', 'salary.id', '=', 'jobs.salaryfrom')
                    ->leftjoin('country', 'country.id', '=', 'jobs.country_id')
                    ->leftjoin('state', 'state.id', '=', 'jobs.state_id')
                    ->leftjoin('Job_functionalarea', 'Job_functionalarea.job_id', '=', 'jobs.id')
                    ->leftjoin('functional_area', 'functional_area.id', '=', 'Job_functionalarea.functional_area_id')
                    ->where('jobs.status','1');
                    if($request->title){
                        $Jobs->where('jobs.jobtitle','like','%' . $request->title . '%');
                    }
                    if($request->category_id){
                        $Jobs->where('jobs.industry_id',$request->category_id);
                    }

                    $Jobs->leftjoin('wishlist', function($join){
                        $join->on('jobs.id','=', "wishlist.job_id");
                        $join->where("wishlist.candidate_id" , Auth::user()->id);
                    });
                    $Jobs->where('appliedjobs.candidate_id',Auth::user()->id);
                    $Jobs->groupBy('jobs.id');
                    $Jobs = $Jobs->paginate(5);

            return $this->respond($Jobs);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
    public function details($job_id){
        if (Auth::check()) {
        $Jobs = DB::table('jobs')
                    ->select('jobs.*',DB::raw('group_concat(functional_area.functional_area) as functional_area'),'salary.salary','companies.location','companies.companyname','companies.companylogo','companies.companydetail','companies.facebook','companies.twitter','companies.linkedin','country.country_name','state.state_name','industries.industry_name as category','wishlist.id as wishlist_id','appliedjobs.status as job_status')
                    ->leftjoin('industries', 'industries.id', '=', 'jobs.industry_id')
                    ->leftjoin('companies', 'companies.user_id', '=', 'jobs.company_id')
                    ->leftjoin('salary', 'salary.id', '=', 'jobs.salaryfrom')
                    ->leftjoin('country', 'country.id', '=', 'jobs.country_id')
                    ->leftjoin('state', 'state.id', '=', 'jobs.state_id')
                    ->leftjoin('Job_functionalarea', 'Job_functionalarea.job_id', '=', 'jobs.id')
                    ->leftjoin('functional_area', 'functional_area.id', '=', 'Job_functionalarea.functional_area_id')
                    ->where('jobs.id',$job_id);

            $Jobs->leftjoin('wishlist', function($join){
                $join->on('jobs.id','=', "wishlist.job_id");
                $join->where("wishlist.candidate_id" , Auth::user()->id);
            });
            $Jobs->leftjoin('appliedjobs', function($join){
                $join->on('jobs.id','=', "appliedjobs.job_id");
                $join->where("appliedjobs.candidate_id" , Auth::user()->id);
            });
             $Jobs = $Jobs->get()->first();

            $json['data'] = $Jobs;
        return $this->respond($json);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
    public function company_job_list(Request $request){
        if (Auth::check()) {
        $Jobs = DB::table('jobs')
                    ->select('jobs.*',DB::raw('group_concat(functional_area.functional_area) as functional_area'),DB::raw('(select count(id) from appliedjobs where appliedjobs.status=2 and appliedjobs.job_id=jobs.id) as applied_pending_count'),DB::raw('(select count(id) from appliedjobs where appliedjobs.status=1 and appliedjobs.job_id=jobs.id) as applied_accepted_count'),'salary.salary','companies.location','companies.companyname','companies.companylogo','companies.companydetail','companies.facebook','companies.twitter','companies.linkedin','country.country_name','state.state_name','industries.industry_name as category')
                    ->leftjoin('industries', 'industries.id', '=', 'jobs.industry_id')
                    ->leftjoin('companies', 'companies.user_id', '=', 'jobs.company_id')
                    ->leftjoin('salary', 'salary.id', '=', 'jobs.salaryfrom')
                    ->leftjoin('country', 'country.id', '=', 'jobs.country_id')
                    ->leftjoin('state', 'state.id', '=', 'jobs.state_id')
                    ->leftjoin('Job_functionalarea', 'Job_functionalarea.job_id', '=', 'jobs.id')
                    ->leftjoin('functional_area', 'functional_area.id', '=', 'Job_functionalarea.functional_area_id')
                    ->where('jobs.status','1')
                    ->where('jobs.company_id',Auth::user()->id);
                    if($request->title){
                        $Jobs->where('jobs.jobtitle','like','%' . $request->title . '%');
                    }
                    if($request->category_id){
                        $Jobs->where('jobs.industry_id',$request->category_id);
                    }
            
            $Jobs->groupBy('jobs.id');
            $Jobs = $Jobs->paginate(15);


        return $this->respond($Jobs);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
    
    public function manageapplicationslist(Request $request){
        if (Auth::check()) {
            $Jobs = DB::table('jobs')
                    ->select('jobs.*',
                    DB::raw('group_concat(functional_area.functional_area) as functional_area'),'salary.salary','companies.location','companies.companyname','companies.companylogo','companies.companydetail','companies.facebook','companies.twitter','companies.linkedin','country.country_name','state.state_name','industries.industry_name as category')
                    ->leftjoin('industries', 'industries.id', '=', 'jobs.industry_id')
                    ->leftjoin('companies', 'companies.user_id', '=', 'jobs.company_id')
                    ->leftjoin('salary', 'salary.id', '=', 'jobs.salaryfrom')
                    ->leftjoin('country', 'country.id', '=', 'jobs.country_id')
                    ->leftjoin('state', 'state.id', '=', 'jobs.state_id')
                    ->leftjoin('Job_functionalarea', 'Job_functionalarea.job_id', '=', 'jobs.id')
                    ->leftjoin('functional_area', 'functional_area.id', '=', 'Job_functionalarea.functional_area_id')
                    ->where('jobs.status','1')
                    ->where('jobs.company_id',Auth::user()->id);
                    if($request->title){
                        $Jobs->where('jobs.jobtitle','like','%' . $request->title . '%');
                    }
                    if($request->category_id){
                        $Jobs->where('jobs.industry_id',$request->category_id);
                    }
                    $Jobs->groupBy('jobs.id');
                    $Jobs = $Jobs->paginate(5);


                return $this->respond($Jobs);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    } 
    public function getappliedmemberlist(Request $request){
        
        $validation = Validator::make($request->all(), [
            'job_id'=>'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            $Jobs = Appliedjobs::select('users.name','users.lname','users.fname','users.profileimg','appliedjobs.*')->where('job_id', $request->job_id)->where('status','!=',0)
                    ->leftjoin('users','users.id','appliedjobs.candidate_id');
                    $Jobs = $Jobs->paginate(20);
                return $this->respond($Jobs);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    } 
    public function update_applied_member(Request $request){
        
        $validation = Validator::make($request->all(), [
            'id'=>'required',
            'status'=>'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            $Appliedjobs = Appliedjobs::where(['id'=>$request->id])->first();
            if(!empty($Appliedjobs)){
                $Appliedjobs->status = $request->status;
                $Appliedjobs->updated_at = Carbon::now();
                $Appliedjobs->save();
                $Jobs = Appliedjobs::select('users.name','users.lname','users.fname','users.profileimg','appliedjobs.*')->where('job_id', $Appliedjobs->job_id)->where('status','!=',0)
                ->leftjoin('users','users.id','appliedjobs.candidate_id');
                $Jobs = $Jobs->paginate(20);
            return $this->respond($Jobs);
            }else{
                return $this->noRespondWithMessage('Application not found.!');    
            }
           
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    } 
    public function addjob(Request $request){
        
        $validation = Validator::make($request->all(), [
            'jobtitle'             => 'required',
            'jobdescription'       => 'required',
            'jobskill'             => 'required',
            'country_id'           => 'required',
            'state'                => 'required',
            'city'                 => 'required',
            'hidesalary'           => 'required',
            'subCategory'          => 'required',
            'jobtype'              => 'required',
            'positions'            => 'required',
            'degreelevel'          => 'required',
            'experience'           => 'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            $Jobs = new Jobs();
            $Jobs->company_id = Auth::user()->id;
            $Jobs->jobtitle = $request->jobtitle;
            $Jobs->jobdescription = $request->jobdescription;
            $Jobs->country_id = $request->country_id;
            $Jobs->state_id = $request->state;
            $Jobs->salaryfrom = $request->salaryfrom;
            $Jobs->salaryto = $request->salaryto;
            $Jobs->salaryperiod = $request->salaryperiod;
            $Jobs->hidesalary = $request->hidesalary;
            $Jobs->jobtype = implode(",",$request->jobtype);
            $Jobs->jobshift = $request->jobshift;
            $Jobs->positions = $request->positions;
            $Jobs->jobexprirydate = date("Y-m-d",strtotime($request->jobexprirydate));
            $Jobs->experience = $request->experience;
            $Jobs->industry_id = $request->industry_id;
            $Jobs->created_at = Carbon::now();
            $Jobs->status = 1;
            $Jobs->save();
            $insert_id = $Jobs->id;
            if($insert_id){
                foreach($request->city as $city){
                    
                        $Jobcity = new Jobcity();
                        $Jobcity->job_id = $insert_id;
                        $Jobcity->city_id = $city;
                        $Jobcity->created_at = Carbon::now();
                        $Jobcity->updated_at = Carbon::now();
                        $Jobcity->save();
                    
                }
                foreach($request->degreelevel as $degreelevel){
                    
                    $Jobdegreelevel = new Jobdegreelevel();
                    $Jobdegreelevel->job_id = $insert_id;
                    $Jobdegreelevel->degreelevel_id = $degreelevel;
                    $Jobdegreelevel->created_at = Carbon::now();
                    $Jobdegreelevel->updated_at = Carbon::now();
                    $Jobdegreelevel->save();
                
                }
                foreach($request->subCategory as $subCategory){
                    
                    $Jobfunctionalarea = new Jobfunctionalarea();
                    $Jobfunctionalarea->job_id = $insert_id;
                    $Jobfunctionalarea->functional_area_id = $subCategory;
                    $Jobfunctionalarea->created_at = Carbon::now();
                    $Jobfunctionalarea->updated_at = Carbon::now();
                    $Jobfunctionalarea->save();
                
                }
                foreach($request->jobskill as $jobskill){
                    
                    $Jobskilllevel = new Jobskilllevel();
                    $Jobskilllevel->job_id = $insert_id;
                    $Jobskilllevel->skill_id = $jobskill['skill_id'];
                    $Jobskilllevel->level_id = $jobskill['level_id'];
                    $Jobskilllevel->created_at = Carbon::now();
                    $Jobskilllevel->updated_at = Carbon::now();
                    $Jobskilllevel->save();
                
                }
            }
            $Jobs_list = DB::table('jobs')
                    ->select('jobs.*',
                    DB::raw('group_concat(functional_area.functional_area) as functional_area'),'salary.salary','companies.location','companies.companyname','companies.companylogo','companies.companydetail','companies.facebook','companies.twitter','companies.linkedin','country.country_name','state.state_name','industries.industry_name as category')
                    ->leftjoin('industries', 'industries.id', '=', 'jobs.industry_id')
                    ->leftjoin('companies', 'companies.user_id', '=', 'jobs.company_id')
                    ->leftjoin('salary', 'salary.id', '=', 'jobs.salaryfrom')
                    ->leftjoin('country', 'country.id', '=', 'jobs.country_id')
                    ->leftjoin('state', 'state.id', '=', 'jobs.state_id')
                    ->leftjoin('Job_functionalarea', 'Job_functionalarea.job_id', '=', 'jobs.id')
                    ->leftjoin('functional_area', 'functional_area.id', '=', 'Job_functionalarea.functional_area_id')
                    ->where('jobs.status','1')
                    ->where('jobs.company_id',Auth::user()->id);
                    $Jobs_list->groupBy('jobs.id');
                    $Jobs_list = $Jobs_list->paginate(5);


                return $this->respond($Jobs_list);
                    
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
    public function updatejob(Request $request){
        
        $validation = Validator::make($request->all(), [
            'jobtitle'             => 'required',
            'jobdescription'       => 'required',
            'jobskill'             => 'required',
            'country_id'           => 'required',
            'state'                => 'required',
            'city'                 => 'required',
            'hidesalary'           => 'required',
            'subCategory'          => 'required',
            'jobtype'              => 'required',
            'positions'            => 'required',
            'degreelevel'          => 'required',
            'experience'           => 'required',
            'job_id'               => 'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            $Jobs = Jobs::where('id',$request->job_id)->first();
            if(!empty($Jobs)){
                $Jobs->company_id = Auth::user()->id;
                $Jobs->jobtitle = $request->jobtitle;
                $Jobs->jobdescription = $request->jobdescription;
                $Jobs->country_id = $request->country_id;
                $Jobs->state_id = $request->state;
                $Jobs->salaryfrom = $request->salaryfrom;
                $Jobs->salaryto = $request->salaryto;
                $Jobs->salaryperiod = $request->salaryperiod;
                $Jobs->hidesalary = $request->hidesalary;
                $Jobs->jobtype = implode(",",$request->jobtype);
                $Jobs->jobshift = $request->jobshift;
                $Jobs->positions = $request->positions;
                $Jobs->jobexprirydate = date("Y-m-d",strtotime($request->jobexprirydate));
                $Jobs->experience = $request->experience;
                $Jobs->industry_id = $request->industry_id;
                $Jobs->created_at = Carbon::now();
                $Jobs->status = 1;
                $Jobs->save();
                $insert_id = $Jobs->id;
                Jobcity::where('job_id',$insert_id)->delete();
                Jobdegreelevel::where('job_id',$insert_id)->delete();
                Jobfunctionalarea::where('job_id',$insert_id)->delete();
                Jobskilllevel::where('job_id',$insert_id)->delete();
                if($insert_id){
                    foreach($request->city as $city){
                        
                            $Jobcity = new Jobcity();
                            $Jobcity->job_id = $insert_id;
                            $Jobcity->city_id = $city;
                            $Jobcity->created_at = Carbon::now();
                            $Jobcity->updated_at = Carbon::now();
                            $Jobcity->save();
                        
                    }
                    foreach($request->degreelevel as $degreelevel){
                        
                        $Jobdegreelevel = new Jobdegreelevel();
                        $Jobdegreelevel->job_id = $insert_id;
                        $Jobdegreelevel->degreelevel_id = $degreelevel;
                        $Jobdegreelevel->created_at = Carbon::now();
                        $Jobdegreelevel->updated_at = Carbon::now();
                        $Jobdegreelevel->save();
                    
                    }
                    foreach($request->subCategory as $subCategory){
                        
                        $Jobfunctionalarea = new Jobfunctionalarea();
                        $Jobfunctionalarea->job_id = $insert_id;
                        $Jobfunctionalarea->functional_area_id = $subCategory;
                        $Jobfunctionalarea->created_at = Carbon::now();
                        $Jobfunctionalarea->updated_at = Carbon::now();
                        $Jobfunctionalarea->save();
                    
                    }
                    foreach($request->jobskill as $jobskill){
                        
                        $Jobskilllevel = new Jobskilllevel();
                        $Jobskilllevel->job_id = $insert_id;
                        $Jobskilllevel->skill_id = $jobskill['skill_id'];
                        $Jobskilllevel->level_id = $jobskill['level_id'];
                        $Jobskilllevel->created_at = Carbon::now();
                        $Jobskilllevel->updated_at = Carbon::now();
                        $Jobskilllevel->save();
                    
                    }
                }
                $Jobs_list = DB::table('jobs')
                        ->select('jobs.*',
                        DB::raw('group_concat(functional_area.functional_area) as functional_area'),'salary.salary','companies.location','companies.companyname','companies.companylogo','companies.companydetail','companies.facebook','companies.twitter','companies.linkedin','country.country_name','state.state_name','industries.industry_name as category')
                        ->leftjoin('industries', 'industries.id', '=', 'jobs.industry_id')
                        ->leftjoin('companies', 'companies.user_id', '=', 'jobs.company_id')
                        ->leftjoin('salary', 'salary.id', '=', 'jobs.salaryfrom')
                        ->leftjoin('country', 'country.id', '=', 'jobs.country_id')
                        ->leftjoin('state', 'state.id', '=', 'jobs.state_id')
                        ->leftjoin('Job_functionalarea', 'Job_functionalarea.job_id', '=', 'jobs.id')
                        ->leftjoin('functional_area', 'functional_area.id', '=', 'Job_functionalarea.functional_area_id')
                        ->where('jobs.status','1')
                        ->where('jobs.company_id',Auth::user()->id);
                        $Jobs_list->groupBy('jobs.id');
                        $Jobs_list = $Jobs_list->paginate(5);
    
    
                    return $this->respond($Jobs_list);
                        
                
                }else{
                    return $this->noRespondWithMessage('Job not Found.!');
                }
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
    public function getjobinfo(Request $request){
         
        $validation = Validator::make($request->all(), [
            'job_id'=>'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            
            
        $Jobs = Jobs::select('id','jobtitle','jobdescription','country_id','state_id','salaryfrom','salaryto','salaryperiod','hidesalary','jobtype','jobshift','positions','jobexprirydate','experience','industry_id')->where('id',$request->job_id)->first();
        $Jobs->jobtype = explode(',',$Jobs->jobtype);
        $Jobcity = Jobcity::select('city_id')->where('job_id',$request->job_id)->get();
        $citys_temp = array();
        foreach($Jobcity as $citys){
            $citys_temp[] = $citys->city_id;
        }
        $Jobdegreelevel = Jobdegreelevel::select('degreelevel_id')->where('job_id',$request->job_id)->get();
        $degreelevel_id = array();
        foreach($Jobdegreelevel as $degreelevel){
            $degreelevel_id[] = $degreelevel->degreelevel_id;
        }
        $Jobfunctionalarea = Jobfunctionalarea::select('functional_area_id')->where('job_id',$request->job_id)->get();
        $functional_area_id = array();
        foreach($Jobfunctionalarea as $functionalarea){
            $functional_area_id[] = $functionalarea->functional_area_id;
        }
        $Jobskilllevel = Jobskilllevel::select('skill_id','level_id')->where('job_id',$request->job_id)->get();
        
        $return['data'] = $Jobs;
        $return['Jobcity'] = $citys_temp;
        $return['degreelevel'] = $degreelevel_id;
        $return['functionalarea'] = $functional_area_id;
        $return['Jobskilllevel'] = $Jobskilllevel;
        return $this->respond($return);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
}
