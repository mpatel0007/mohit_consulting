<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\Companies;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\Jobs;
use App\Models\Jobskilllevel;
use App\Models\Jobdegreelevel;
use App\Models\Jobcity;
use App\Models\Degreelevel;
use App\Models\Functional_area;
use App\Models\Degreetype;
use App\Models\Jobfunctionalarea;
use App\Models\Jobskill;
use App\Models\Industries;
use App\Models\Careerlevel;
use App\Models\Salary;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use DataTables;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

class JobsController extends Controller
{
    public function jobsform()
    {
        $Companies = Companies::select('id','companyname')->get();
        $industry = Industries::select('id', 'industry_name')->get();
        $country = Country::select('id','country_name')->get();
        $degreelevel =  Degreelevel::select('id','degreelevel')->get();
        $degreetype =  Degreetype::select('id','degreetype')->get();
        $jobskill =     Jobskill::select('id','jobskill')->get();
        $career =  Careerlevel::select('id','careerlevel')->get();
        $get_jobskill =  Jobskill::select('id','jobskill')->get();
        $salaries =  Salary::select('id','salary')->get();

        return view('Admin/jobs/addjobs')->with(compact('career','Companies','industry','jobskill','get_jobskill','country','degreelevel','degreetype','salaries'));
    }

    public function addjobs(Request $request){
        $update_id = $request->input('hid');  
        
        $validation = Validator::make($request->all(), [
            // 'company'              => 'required',
            'jobtitle'             => 'required',
            'jobdescription'       => 'required',
            'jobskill'             => 'required',
            'country'              => 'required',
            'state'                => 'required',
            'city'                 => 'required',
            //'freelance'            => 'required',
            'career'               => 'required',
            // 'salaryfrom'           => 'required',
            // 'salaryto'             => 'required',
            // 'salaryperiod'         => 'required',
            'hidesalary'           => 'required',
            'subCategory'           => 'required',
            'jobtype'              => 'required',
            // 'jobshift'             => 'required',
            'positions'            => 'required',
            'gender'               => 'required',
            // 'yearly_job_salary'    => 'required',
            'degreelevel'          => 'required',
            'experience'           => 'required',
        ]);
        if(empty($update_id)){
            $validation->company = 'required';
        }
        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }
        $JobsData = $request->all();
        $allJobType =  implode(",", $JobsData['jobtype']);
        $gender = implode(",", $JobsData['gender']);

        if(empty($update_id)){
            $company_id = $JobsData['company'];
        }else{
            $company_id = $JobsData['company_edit'];
        }

        $company_dateils = Companies::where('id',$company_id)->first();
        
        // $allDegreelevel =  implode(",", $JobsData['degreelevel']);
        $result['status'] = 0;
        $result['msg'] = "Please enter valid data";
        $Jobs = new Jobs();
        if($update_id == '' && $update_id == null){
            $Jobs->company_id            = $company_dateils->user_id;
            $Jobs->jobtitle              = $JobsData['jobtitle'];
            $Jobs->jobdescription        = $JobsData['jobdescription'];
            $Jobs->jobskill_id           = $JobsData['jobskill'];
            $Jobs->country_id            = $JobsData['country'];
            $Jobs->state_id              = $JobsData['state'];
            // $Jobs->city_id               = $allCity;
            $Jobs->gender                = $gender;
            $Jobs->is_freelance          = $JobsData['freelance'];
            $Jobs->careerlevel           = $JobsData['career'];
            $Jobs->salaryfrom            = $JobsData['salaryfrom'];
            $Jobs->salaryto              = $JobsData['salaryto'];
            $Jobs->salaryperiod          = $JobsData['salaryperiod'];
            // $Jobs->yearly_job_salary     = $JobsData['yearly_job_salary'];
            $Jobs->hidesalary            = $JobsData['hidesalary'];
            // $Jobs->functional_id         = $JobsData['functional'];
            $Jobs->jobtype               = $allJobType;
            $Jobs->jobshift              = $JobsData['jobshift'];
            $Jobs->positions             = $JobsData['positions'];
            // $Jobs->gender                = $JobsData['gender'];
            $Jobs->jobexprirydate        = $JobsData['jed'];
            $Jobs->experience            = $JobsData['experience'];
            $Jobs->industry_id           = $JobsData['industry'];
            $Jobs->status                = $JobsData['status'];
            $Jobs->reject_reason         = $JobsData['rejectReason'];
            $Jobs->save();
            $insert_id = $Jobs->id;
            if($insert_id > 0) {
                $result['status'] = 1;
                $result['msg'] = "Job inserted successfully";
            }
            if(!empty($insert_id)){
                $city_ids = $JobsData['city'];                
                foreach ($city_ids as $city_id) {
                        $insert_city = new Jobcity();   
                        $insert_city->city_id       = $city_id;
                        $insert_city->job_id        = $company_dateils->user_id;
                        $insert_city->save();
                }
                $allDegreelevel =  $JobsData['degreelevel'];
                if($allDegreelevel != '' && $allDegreelevel != null ){
                    foreach ($allDegreelevel as $key => $Degreelevel_id) {
                        $Jobdegreelevel = new Jobdegreelevel();   
                        $Jobdegreelevel->job_id              = $company_dateils->user_id;
                        $Jobdegreelevel->degreelevel_id      = $Degreelevel_id;
                        $Jobdegreelevel->save();
                    }
                }

                $job_functionalarea =  $JobsData['subCategory'];
                if($job_functionalarea != '' && $job_functionalarea != null ){
                    foreach ($job_functionalarea as $key => $functional_area_id) {
                        $Jobfunctionalarea = new Jobfunctionalarea();   
                        $Jobfunctionalarea->job_id                  = $company_dateils->user_id;
                        $Jobfunctionalarea->functional_area_id      = $functional_area_id;
                        $Jobfunctionalarea->save();
                    }
                }

                if(isset($JobsData['skill']) && isset($JobsData['level'])){
                    $skill_ids = $JobsData['skill'];
                    $level_ids = $JobsData['level'];                     
                        if($skill_ids != "" && $level_ids != ""){
                            foreach ($skill_ids as $key => $skill_id) {
                                $Jobskilllevel = new Jobskilllevel();   
                                $Jobskilllevel->job_id        = $company_dateils->user_id;
                                $Jobskilllevel->skill_id      = $skill_id;
                                $Jobskilllevel->level_id      = $level_ids[$key];
                                $Jobskilllevel->save();
                            }
                        }else{
                            $result['status'] = 0;
                            $result['msg'] = "Select Job skill and career level";
                        }
                }
            }
        }else{
            $UpdateDetails = Jobs::where('id',$update_id)->first();
            $UpdateDetails->company_id            = $company_dateils->user_id;
            $UpdateDetails->jobtitle              = $JobsData['jobtitle'];
            $UpdateDetails->jobdescription        = $JobsData['jobdescription'];
            $UpdateDetails->jobskill_id           = $JobsData['jobskill'];
            $UpdateDetails->country_id            = $JobsData['country'];
            $UpdateDetails->state_id              = $JobsData['state'];
            // $UpdateDetails->city_id               = $allCity;
            $UpdateDetails->gender                = $gender;
            $UpdateDetails->is_freelance          = $JobsData['freelance'];
            $UpdateDetails->careerlevel           = $JobsData['career'];
            $UpdateDetails->salaryfrom            = $JobsData['salaryfrom'];
            $UpdateDetails->salaryto              = $JobsData['salaryto'];
            // $UpdateDetails->yearly_job_salary     = $JobsData['yearly_job_salary'];
            $UpdateDetails->salaryperiod          = $JobsData['salaryperiod'];
            $UpdateDetails->hidesalary            = $JobsData['hidesalary'];
            // $UpdateDetails->functional_id         = $JobsData['functional'];
            $UpdateDetails->jobtype               = $allJobType;             
            $UpdateDetails->jobshift              = $JobsData['jobshift'];
            $UpdateDetails->positions             = $JobsData['positions'];
            // $UpdateDetails->gender                = $JobsData['gender'];
            $UpdateDetails->jobexprirydate        = $JobsData['jed'];
            // $UpdateDetails->degreelevel_id        = $allDegreelevel;
            $UpdateDetails->experience            = $JobsData['experience'];
            $UpdateDetails->industry_id           = $JobsData['industry'];
            $UpdateDetails->status                = $JobsData['status'];
            $UpdateDetails->reject_reason         = $JobsData['rejectReason'];
            $UpdateDetails->save();
            $result['status'] = 1;
            $result['msg'] = "Job Updated Successfully";

            if($update_id != '' && $update_id != null){
                $del_Jobdegreelevel      = Jobdegreelevel::where('job_id',$company_dateils->user_id)->delete();
                $del_Skill               = Jobskilllevel::where('job_id',$company_dateils->user_id)->delete();
                $del_city                = Jobcity::where('job_id',$company_dateils->user_id)->delete();
                $del_Jobfunctionalarea   = Jobfunctionalarea::where('job_id',$company_dateils->user_id)->delete();
                $city_ids = $JobsData['city'];                
                foreach ($city_ids as $city_id) {
                        $insert_city = new Jobcity();   
                        $insert_city->city_id       = $city_id;
                        $insert_city->job_id        = $company_dateils->user_id;
                        $insert_city->save();
                }
                $allDegreelevel =  $JobsData['degreelevel'];
                if($allDegreelevel != '' && $allDegreelevel != null ){
                    foreach ($allDegreelevel as $key => $Degreelevel_id) {
                        $Jobdegreelevel = new Jobdegreelevel();   
                        $Jobdegreelevel->job_id              = $company_dateils->user_id;
                        $Jobdegreelevel->degreelevel_id      = $Degreelevel_id;
                        $Jobdegreelevel->save();
                    }
                }

                $job_functionalarea =  $JobsData['subCategory'];
                if($job_functionalarea != '' && $job_functionalarea != null ){
                    foreach ($job_functionalarea as $key => $functional_area_id) {
                        $Jobfunctionalarea = new Jobfunctionalarea();   
                        $Jobfunctionalarea->job_id                  = $company_dateils->user_id;
                        $Jobfunctionalarea->functional_area_id      = $functional_area_id;
                        $Jobfunctionalarea->save();
                    }
                } 
                
            if(isset($JobsData['skill']) && isset($JobsData['level'])){
                $skill_ids = $JobsData['skill'];
                $level_ids = $JobsData['level'];                
                    if($skill_ids != "" && $level_ids != ""){
                        foreach ($skill_ids as $key => $skill_id) {
                            $Jobskilllevel = new Jobskilllevel();   
                            $Jobskilllevel->job_id        = $company_dateils->user_id;
                            $Jobskilllevel->skill_id      = $skill_id;
                            $Jobskilllevel->level_id      = $level_ids[$key];
                            $Jobskilllevel->save();
                        }
                    }else{
                        $result['status'] = 0;
                        $result['msg'] = "Select Job skill and career level";
                    }
                }
            }
        }
        echo json_encode($result);
        exit;
    }

    public function jobslist(){
        return view('Admin/jobs/jobslist');
    }
    
    public function jobslistdatatable(Request $request){
        if ($request->ajax()) {
            $data = Jobs::select('id','jobtitle','status','company_id');
            
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('status', function($row){   
                        $status = "Inactive";
                        if($row->status == 1){
                            $status = "Active";
                        }
                            return $status;
                    })
                    ->addColumn('action', function($row){
                        $action = '<input type="button" value="Delete" class="btn btn-danger " onclick="delete_jobs(' . $row->id . ')">';
                        $action .= '  <a href="'. route("admin-jobs-edit", ["id" => $row->id]).'" class="btn btn-primary"  data-id = "' . $row->id . '">Edit</a>';       
                        return $action;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    function deletejobsdata(Request $request){
        $delete_id = $request->input('id'); 
        $result['status'] = 0;
        $result['msg'] = "Oops ! Job not deleted !";
        if(!empty($delete_id)){
            $del_sql = Jobs::where('id',$delete_id)->delete();
            if($del_sql){
                $result['status'] = 1;
                $result['msg'] = "Job Deleted Successfully";
              }
        }
      echo json_encode($result);
      exit;
    }

    public function editjobsdata($id){
        
        if(!empty($id)){
            $edit_sql = Jobs::where('id',$id)->first();
            $getcity = Jobcity::where('job_id',$id)->get();
            $Fillcity_id = array();
            foreach($getcity as $city_id)
            {
                $Fillcity_id[] =  $city_id['city_id'];
            }
            $getSkill = Jobskilllevel::where('job_id',$id)->get();
            $Fillskill_id = array();
            $Filllevel_id = array();
            $count = 0;
            foreach($getSkill as $skill_id)
            {
                $Fillskill_id[] = $skill_id['skill_id'];
                $Filllevel_id[] = $skill_id['level_id'];
                $count = count($Filllevel_id);
            }
            $Jobfunctionalarea = Jobfunctionalarea::where('job_id',$id)->get()->toArray();
            $Jobfunctionalarea_id = array();
            foreach($Jobfunctionalarea as $functionalarea_id)
            {
                $Jobfunctionalarea_id[] =  $functionalarea_id['functional_area_id'];
            }

            $Jobdegreelevel = Jobdegreelevel::where('job_id',$id)->get();
            $Filldegreelevel_id = array();
            foreach($Jobdegreelevel as $degreelevel_id)
            {
                $Filldegreelevel_id[] =  $degreelevel_id['degreelevel_id'];
            }
            
            if(!empty($edit_sql)){
                $Jobs_edit_data = $edit_sql;
                $array = $edit_sql['jobtype'];
                $jobTypes = explode(",",$array);
                $Fillgender = explode(",",$edit_sql['gender']);
                // $fillDegreelevel = explode(",",$edit_sql['degreelevel_id']);
                $country        = Country::select('id','country_name')->get();
                $selected_country = $Jobs_edit_data->country_id;
                $selected_state = $Jobs_edit_data->state_id;
		        $state          = State::where('country_id',$selected_country)->get();
                $city           = City::where('state_id',$selected_state)->get();
                $functional_area = Functional_area::select('id','functional_area')->get();
                $Companies      = Companies::select('id','companyname')->get();
                $industry       = Industries::select('id', 'industry_name')->get();
                $degreelevel    =  Degreelevel::select('id','degreelevel')->get();
                $degreetype     =  Degreetype::select('id','degreetype')->get();
                $jobskill       =  Jobskill::select('id','jobskill')->get();
                $get_jobskill   =  Jobskill::select('id','jobskill')->get();
                $career         =  Careerlevel::select('id','careerlevel')->get()->all();
                // $subCategories  = Functional_area::where('industry_id',$Jobs_edit_data->industry_id)->get();

                $subCategories  = Functional_area::where('industry_id',isset($Jobs_edit_data->industry_id) ? $Jobs_edit_data->industry_id : '')->get();
                
                $salaries       =  Salary::select('id','salary')->get();
            }
            return view('Admin/jobs/addjobs')->with(compact('Jobs_edit_data','career','count','Filldegreelevel_id','subCategories','industry','Jobfunctionalarea_id','Fillgender','get_jobskill','Fillskill_id','Filllevel_id','Fillcity_id','jobskill','jobTypes','degreelevel', 'degreetype','Companies','city','state','country','functional_area','salaries'));
        }
    }
}