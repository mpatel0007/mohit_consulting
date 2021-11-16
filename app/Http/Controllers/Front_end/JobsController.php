<?php

namespace App\Http\Controllers\Front_end;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\Companies;
use App\Models\Country;
use App\Models\City;
use App\Models\State;
use App\Models\Jobs;
use App\Models\Appliedjobs;
use App\Models\Userprofile;
use App\Models\Degreelevel;
use App\Models\Userprofiledegreelevel;
use App\Models\Functional_area;
use App\Models\Jobskilllevel;
use App\Models\Jobdegreelevel;
use App\Models\Jobcity;
use App\Models\Degreetype;
use App\Models\Jobskill;
use App\Models\Industries;
use App\Models\Jobfunctionalarea;
use App\Models\Careerlevel;
use App\Models\Teamuprequest;
use App\Models\Salary;
use App\Models\ApplicationRejectReason;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use DataTables;
use Response;
use DB;
use Mail;
use App\Helper\Helper;
use Carbon\Carbon;

class JobsController extends Controller
{
    public function postjobsform()
    {
        Helper::isEmployers();
        $Companies       = Companies::select('id', 'companyname')->get();
        $country         = Country::select('id', 'country_name')->get();
        $degreelevel     = Degreelevel::select('id', 'degreelevel')->get();
        $functional_area = Functional_area::select('id', 'functional_area')->get();
        $degreetype      = Degreetype::select('id', 'degreetype')->get();
        $jobskill        = Jobskill::select('id', 'jobskill')->get();
        $career          = Careerlevel::select('id', 'careerlevel')->get();
        $get_jobskill    = Jobskill::select('id', 'jobskill')->get();
        $industry        = Industries::select('id', 'industry_name')->get();
        $salaries        =  Salary::select('id', 'salary')->get();

        return view('Front_end/employers/jobs/postjob')->with(compact('salaries', 'Companies', 'career', 'industry', 'get_jobskill', 'jobskill', 'country', 'functional_area', 'degreelevel', 'degreetype'));
    }

    public function postjobs(Request $request)
    {
        
        $validation = Validator::make($request->all(), [
            // 'company'              => 'required',
            'jobtitle'             => 'required',
            // 'jobdescription'       => 'required',
            'jobskill'             => 'required',
            'country'              => 'required',
            'state'                => 'required',
            'city'                 => 'required',
            // 'freelance'            => 'required',
            // 'career'               => 'required',
            // 'hidesalary'           => 'required',
            'subCategory'           => 'required',
            'jobtype'              => 'required',
            'positions'            => 'required',
            // 'gender'               => 'required',
            'degreelevel'          => 'required',
            'experience'          => 'required',
        ]);
        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }
        $JobsData = $request->all();
        $update_id = $request->input('hid');
        // $gender = implode(",", $JobsData['gender']);
        $allJobType =  implode(",", $JobsData['jobtype']);

        $employers_id    = Auth::guard('candidate')->id();

        $result['status'] = 0;
        $result['msg'] = "Please enter valid data";
        $Jobs = new Jobs();
        if ($update_id == '' && $update_id == null) {
            $Jobs->company_id            = $employers_id;
            // company_id is a user_id
            $Jobs->jobtitle              = $JobsData['jobtitle'];
            $Jobs->jobdescription        = $JobsData['jobdescription'];
            $Jobs->jobskill_id           = $JobsData['jobskill'];
            $Jobs->country_id            = $JobsData['country'];
            $Jobs->state_id              = $JobsData['state'];
            // $Jobs->city_id               = $JobsData['city'];
            // $Jobs->gender                = $JobsData['gender'];
            // $Jobs->is_freelance          = $JobsData['freelance'];
            $Jobs->careerlevel           = $JobsData['career'];
            $Jobs->salaryfrom            = $JobsData['salaryfrom'];
            $Jobs->salaryto              = $JobsData['salaryto'];
            $Jobs->salaryperiod          = $JobsData['salaryperiod'];
            // $Jobs->hidesalary            = $JobsData['hidesalary'];
            // $Jobs->functional_id         = $JobsData['functional'];  
            $Jobs->jobtype               = $allJobType;
            $Jobs->jobshift              = $JobsData['jobshift'];
            $Jobs->positions             = $JobsData['positions'];
            // $Jobs->gender                = $gender;
            $Jobs->jobexprirydate        = $JobsData['jed'];
            // $Jobs->yearly_job_salary     = $JobsData['yearly_job_salary'];
            $Jobs->experience            = $JobsData['experience'];
            $Jobs->industry_id           = $JobsData['industry'];
            $Jobs->status                = 1    ;
            $Jobs->reject_reason         = $JobsData['rejectReason'];
            $Jobs->save();
            $insert_id = $Jobs->id;
            if ($insert_id > 0) {
                $result['status'] = 1;
                $result['msg'] = "Job inserted successfully";
            }
            if (!empty($insert_id)) {
                if (isset($JobsData['city'])) {
                    $city_ids = $JobsData['city'];
                    foreach ($city_ids as $city_id) {
                        $insert_city = new Jobcity();
                        $insert_city->city_id       = $city_id;
                        $insert_city->job_id        = $insert_id;
                        $insert_city->save();
                    }
                }
                if (isset($JobsData['degreelevel'])) {
                    $allDegreelevel =  $JobsData['degreelevel'];
                    if ($allDegreelevel != '' && $allDegreelevel != null) {
                        foreach ($allDegreelevel as $key => $Degreelevel_id) {
                            $Jobdegreelevel = new Jobdegreelevel();
                            $Jobdegreelevel->job_id              = $insert_id;
                            $Jobdegreelevel->degreelevel_id      = $Degreelevel_id;
                            $Jobdegreelevel->save();
                        }
                    }
                }
                $job_functionalarea =  $JobsData['subCategory'];
                if ($job_functionalarea != '' && $job_functionalarea != null) {
                    foreach ($job_functionalarea as $key => $functional_area_id) {
                        $Jobfunctionalarea = new Jobfunctionalarea();
                        $Jobfunctionalarea->job_id                  = $insert_id;
                        $Jobfunctionalarea->functional_area_id      = $functional_area_id;
                        $Jobfunctionalarea->save();
                    }
                }
                if (isset($JobsData['skill']) && isset($JobsData['level'])) {
                    $skill_ids = $JobsData['skill'];
                    $level_ids = $JobsData['level'];
                    if ($skill_ids != "" && $level_ids != "") {
                        foreach ($skill_ids as $key => $skill_id) {
                            $Jobskilllevel = new Jobskilllevel();
                            $Jobskilllevel->job_id        = $insert_id;
                            $Jobskilllevel->skill_id      = $skill_id;
                            $Jobskilllevel->level_id      = $level_ids[$key];
                            $Jobskilllevel->save();
                        }
                    } else {
                        $result['status'] = 0;
                        $result['msg'] = "Select Job skill and career level";
                    }
                }
            }
        } else {
            $UpdateDetails = Jobs::where('id', $update_id)->first();
            $UpdateDetails->company_id          = $employers_id;
            $UpdateDetails->jobtitle            = $JobsData['jobtitle'];
            $UpdateDetails->jobdescription      = $JobsData['jobdescription'];
            // $UpdateDetails->jobskill_id         = $JobsData['jobskill'];
            $UpdateDetails->country_id          = $JobsData['country'];
            $UpdateDetails->state_id            = $JobsData['state'];
            // $UpdateDetails->city_id             = $JobsData['city'];
            // $UpdateDetails->gender              = $JobsData['gender'];
            // $UpdateDetails->yearly_job_salary   = $JobsData['yearly_job_salary'];
            $UpdateDetails->careerlevel         = $JobsData['career'];
            $UpdateDetails->salaryfrom          = $JobsData['salaryfrom'];
            $UpdateDetails->salaryto            = $JobsData['salaryto'];
            $UpdateDetails->salaryperiod        = $JobsData['salaryperiod'];
            // $UpdateDetails->hidesalary          = $JobsData['hidesalary'];
            // $UpdateDetails->functional_id       = $JobsData['functional'];
            $UpdateDetails->jobtype             = $allJobType;
            $UpdateDetails->jobshift            = $JobsData['jobshift'];
            $UpdateDetails->positions           = $JobsData['positions'];
            // $UpdateDetails->gender              = $gender;
            $UpdateDetails->jobexprirydate      = $JobsData['jed'];
            // $UpdateDetails->degreelevel_id      = $JobsData['degreelevel'];
            $UpdateDetails->experience          = $JobsData['experience'];
            $UpdateDetails->industry_id         = $JobsData['industry'];
            // $UpdateDetails->status              = $JobsData['status'];
            $UpdateDetails->reject_reason       = $JobsData['rejectReason'];
            $UpdateDetails->save();
            $result['status'] = 1;
            $result['msg'] = "Job Updated Successfully";
            if ($update_id != '' && $update_id != null) {
                $del_Jobdegreelevel      = Jobdegreelevel::where('job_id', $update_id)->delete();
                $del_Skill               = Jobskilllevel::where('job_id', $update_id)->delete();
                $del_city                = Jobcity::where('job_id', $update_id)->delete();
                $del_Jobfunctionalarea   = Jobfunctionalarea::where('job_id', $update_id)->delete();

                $city_ids = $JobsData['city'];
                foreach ($city_ids as $city_id) {
                    $insert_city = new Jobcity();
                    $insert_city->city_id       = $city_id;
                    $insert_city->job_id        = $update_id;
                    $insert_city->save();
                }
                $allDegreelevel =  $JobsData['degreelevel'];
                if ($allDegreelevel != '' && $allDegreelevel != null) {
                    foreach ($allDegreelevel as $key => $Degreelevel_id) {
                        $Jobdegreelevel = new Jobdegreelevel();
                        $Jobdegreelevel->job_id              = $update_id;
                        $Jobdegreelevel->degreelevel_id      = $Degreelevel_id;
                        $Jobdegreelevel->save();
                    }
                }
                $job_functionalarea =  $JobsData['subCategory'];
                if ($job_functionalarea != '' && $job_functionalarea != null) {
                    foreach ($job_functionalarea as $key => $functional_area_id) {
                        $Jobfunctionalarea = new Jobfunctionalarea();
                        $Jobfunctionalarea->job_id                  = $update_id;
                        $Jobfunctionalarea->functional_area_id      = $functional_area_id;
                        $Jobfunctionalarea->save();
                    }
                }
                if (isset($JobsData['skill']) && isset($JobsData['level'])) {
                    $skill_ids = $JobsData['skill'];
                    $level_ids = $JobsData['level'];
                    if ($skill_ids != "" && $level_ids != "") {
                        foreach ($skill_ids as $key => $skill_id) {
                            $Jobskilllevel = new Jobskilllevel();
                            $Jobskilllevel->job_id        = $update_id;
                            $Jobskilllevel->skill_id      = $skill_id;
                            $Jobskilllevel->level_id      = $level_ids[$key];
                            $Jobskilllevel->save();
                        }
                    } else {
                        $result['status'] = 0;
                        $result['msg'] = "Select Job skill and career level";
                    }
                }
            }
        }
        echo json_encode($result);
        exit;
    }

    public function managejobsview()
    {
        Helper::isEmployers();
        return view('Front_end/employers/jobs/managejobs');
    }

    public function changepasswordview()
    {
        return view('Front_end/employers/jobs/changepassword');
    }

    public function manageapplicationsview()
    {
        Helper::isEmployers();
        return view('Front_end/employers/jobs/manageapplications');
    }

    public function candidate_details_view($candidate_id,$teamID = null ){   
        
        // $teamID = isset($_GET['teamID']) ? $_GET['teamID'] : $teamID;
        $teamUpList = isset($_GET['teamuplist']) ? $_GET['teamuplist'] : '';
        $team_request = isset($_GET['team_request']) ? $_GET['team_request'] : '';

        Helper::isEmployers();
        $query = DB::table('users')
            ->select('users.*', 'country.country_name as country', 'city.city_name as city', 'jobskill.jobskill as jobskill', 'state.state_name as state', 'functional_area.functional_area as functional_area','salary.salary as salary')
            ->leftjoin("country", "users.country_id", "=", "country.id")
            ->leftjoin("city", "users.city_id",  "=", "city.id")
            ->leftjoin("state", "users.state_id", "=", "state.id")
            ->leftjoin("jobskill", "jobskill.id", "=", "users.jobskill_id")
            ->leftjoin("functional_area", "users.functional_id", "=", "functional_area.id")
            ->leftjoin("salary", "users.currentsalary", "=", "salary.id")
            // ->leftjoin("salary", "users.expectedsalary", "=", "salary.id")
            ->where('users.id', $candidate_id)
            ->first();

        $jobskill = DB::table('userprofile_skilllevel')
            ->select('userprofile_skilllevel.*', 'jobskill.jobskill as jobskill',)
            ->leftjoin("jobskill", "jobskill.id", "=", "userprofile_skilllevel.skill_id")
            ->get();
        // if($teamID != '' && $teamUpList != ''){
            $requestStatus = Teamuprequest::where('candidate_id',$candidate_id)->where('team_id',$teamID)->get();
            // $requestDescription = Teamuprequest::where('candidate_id',Auth::guard('candidate')->id())->where('team_id',$teamID)->get();
            

        // }
        $Userprofiledegreelevel = Userprofiledegreelevel::where('userprofile_id', $candidate_id)->get();
        $Filldegreelevel_id = array();
        foreach ($Userprofiledegreelevel as $degreelevel_id) {
            $Filldegreelevel_id[] =  $degreelevel_id['degreelevel_id'];
        }
        return view('Front_end/employers/jobs/candidateprofile')->with(compact('query','requestStatus','team_request','teamID','candidate_id','teamUpList','Filldegreelevel_id', 'jobskill'));
    }

    public function resume_dowload($candidate_id)
    {
        Helper::isEmployers();
        $Userprofile = Userprofile::where('id', $candidate_id)->first();
        if ($Userprofile->resume != '' & $Userprofile->resume != '') {
            $file = public_path('assets/front_end/Upload/User_Resume/' . $Userprofile->resume . '');
            if (file_exists($file)) {
                return Response::download($file);
            } else {
                return back()->with('error', 'Error !! Resume Not Found.');
            }
        } else {
            return back()->with('error', 'Error !! Resume Not Uploaded.');
        }
    }

    public function coverletter_dowload($candidate_id)
    {
        Helper::isEmployers();
        $Userprofile = Userprofile::where('id', $candidate_id)->first();
        if ($Userprofile->coverletter != '' & $Userprofile->coverletter != '') {
            $file = public_path('assets/front_end/Upload/User_Cover_Letter/' . $Userprofile->coverletter . '');
            if (file_exists($file)) {
                return Response::download($file);
            } else {
                return back()->with('error', 'Error !! Cover Letter Not Found.');
            }
        } else {
            return back()->with('error', 'Error !! Cover Letter Not Uploaded.');
        }
    }

    public function references_dowload($candidate_id)
    {
        $Userprofile = Userprofile::where('id', $candidate_id)->first();
        if ($Userprofile->references != '' & $Userprofile->references != '') {
            $file = public_path('assets/front_end/Upload/User_References/' . $Userprofile->references . '');
            if (file_exists($file)) {
                return Response::download($file);
            } else {
                return back()->with('error', 'Error !! References Not Found.');
            }
        } else {
            return back()->with('error', 'Error !! References Not Uploaded.');
        }
    }

    public function attachment_dowload($candidate_id,$job_id)
    {
        $applied_jobs = Appliedjobs::where('candidate_id', $candidate_id)->where('job_id', $job_id)->first();
        
        if ($applied_jobs->document != '' & $applied_jobs->document != '') {
            $file = public_path('assets/front_end/Upload/apply_job_attachment/' . $applied_jobs->document . '');
        
            if (file_exists($file)) {
                return Response::download($file);
            } else {
                return back()->with('error', 'Error !! Attachment Not Found.');
            }
        } else {
            return back()->with('error', 'Error !! Attachment Not Uploaded.');
        }
    }

    public function managejobslist(Request $request)
    {
        if ($request->ajax()) {
            $company_id    = Auth::guard('candidate')->id();
            $data = Jobs::where('company_id', $company_id)->get();

            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('jobtype', function ($row) {
                    $arrayjobtype = explode(',', $row->jobtype);
                    $jobtype = '';
                    foreach ($arrayjobtype as $typeofjob) {
                        if ($typeofjob == 'fulltime') {
                            $jobtype .= '<nobr><span class="full-time">Full-Time</span></nobr>';
                        } else if ($typeofjob == 'parttime') {
                            $jobtype .= '<nobr><span class="part-time">Part-time</span></nobr>';
                        } else if ($typeofjob == 'freelance') {
                            $jobtype .= '<nobr><span class="freelance">Freelance</span></nobr>';
                        } else if ($typeofjob == 'internship') {
                            $jobtype .= '<nobr><span class="internship">Internship</span></nobr>';
                        } else if ($typeofjob == 'contract') {
                            $jobtype .= '<nobr><span class="contract">Contract</span></nobr>';
                        }
                    }
                    return $jobtype;
                })
                ->addColumn('action', function ($row) {
                    $action = "<button  class='delete_job' onclick='delete_jobs(" . $row->id . ")'><i class='fa fa-trash' style='color:#21254C' aria-hidden='true'></i></button>";
                    // <button class='edit_job'  onclick='edit_jobs(" . $row->id . ")'><i class='fa fa-pencil-square' style='color:#21254C' aria-hidden='true'></i></button>";
                    $action .= "<button class='edit_job'><a href=" . route('front_end-jobs-edit', ['id' => $row->id]) . " data-id = '.$row->id.'><i class='fa fa-pencil-square' style='color:#21254C' aria-hidden='true'></i></a></button>";
                    return $action;
                })
                ->rawColumns(['action', 'jobtype'])
                ->make(true);
        }
    }

    // public function changepasswordproccess(Request $request){
    //     echo '<pre>';
    //     print_r("dffd");
    //     die;
    //     $this->validate($request, [
    //         'oldpassword'       => 'required|',
    //         'password'          => 'required|min:6|max:20',
    //         'confirm_password'    => 'required|min:6|max:20|same:password',
    //     ]);
    //     $PasswordData = $request->all();
    //     $user_id   = Auth::guard('employers')->id();
    //     $find_user = Companies::where('id', '=', $user_id)->first();    
    //     if(Hash::check($PasswordData['oldpassword'], $find_user->password)){    
    //         if(!empty($find_user)){
    //             $find_user->password     =  Hash::make($PasswordData['password']);
    //             $find_user->save();
    //             return redirect()->back()->with('success', 'Your Password Change Successfully');
    //         } else {
    //             return redirect()->back()->with('error', 'User does not exist Regiser First!');
    //         }
    //     }else{
    //         return redirect()->back()->with('error', 'The old password you have entered is incorrect');
    //     }
    // }

    public function deletejobs(Request $request)
    {
        $delete_id = $request->id;
        $result['status'] = 0;
        $result['msg'] = "Oops ! jobs Data Not Deleted !";
        if (!empty($delete_id)) {
            $del_sql = Jobs::where('id', $delete_id)->delete();
            if ($del_sql) {
                $result['status'] = 1;
                $result['msg'] = "Jobs Data Deleted Successfully";
            }
        }
        echo json_encode($result);
        exit;
    }

    public function editjobs($id)
    {

        if (!empty($id)) {
            $edit_sql = Jobs::where('id', $id)->first();
            $getcity = Jobcity::where('job_id', $id)->get();
            $Fillcity_id = array();
            foreach ($getcity as $city_id) {
                $Fillcity_id[] =  $city_id['city_id'];
            }
            $getSkill = Jobskilllevel::where('job_id', $id)->get();
            $Fillskill_id = array();
            $Filllevel_id = array();
            $count = 0;
            foreach ($getSkill as $skill_id) {
                $Fillskill_id[] = $skill_id['skill_id'];
                $Filllevel_id[] = $skill_id['level_id'];
                $count = count($Filllevel_id);
            }

            $Jobfunctionalarea = Jobfunctionalarea::where('job_id', $id)->get()->toArray();
            $Jobfunctionalarea_id = array();
            foreach ($Jobfunctionalarea as $functionalarea_id) {
                $Jobfunctionalarea_id[] =  $functionalarea_id['functional_area_id'];
            }

            $Jobdegreelevel = Jobdegreelevel::where('job_id', $id)->get();
            $Filldegreelevel_id = array();
            foreach ($Jobdegreelevel as $degreelevel_id) {
                $Filldegreelevel_id[] =  $degreelevel_id['degreelevel_id'];
            }

            if (!empty($edit_sql)) {
                $Jobs_edit_data = $edit_sql;
                $jobTypes = explode(",", $edit_sql['jobtype']);
                // $Fillgender = explode(",",$edit_sql['gender']);
                // $fillDegreelevel = explode(",",$edit_sql['degreelevel_id']);
                $country = Country::select('id', 'country_name')->get();
                $selected_country = $Jobs_edit_data->country_id;
                $selected_state = $Jobs_edit_data->state_id;
                $state = State::where('country_id', $selected_country)->get();
                $city = City::where('state_id', $selected_state)->get();
                $functional_area = Functional_area::select('id', 'functional_area')->get();
                $Companies     = Companies::select('id', 'companyname')->get();
                $degreelevel   =  Degreelevel::select('id', 'degreelevel')->get();
                $industry      = Industries::select('id', 'industry_name')->get();
                $degreetype    =  Degreetype::select('id', 'degreetype')->get();
                $jobskill      =  Jobskill::select('id', 'jobskill')->get();
                $get_jobskill  =  Jobskill::select('id', 'jobskill')->get();
                $career        =  Careerlevel::select('id', 'careerlevel')->get()->all();
                $subCategories = Functional_area::where('industry_id', $Jobs_edit_data->industry_id)->get();
                $salaries      =  Salary::select('id', 'salary')->get();
            }
            return view('Front_end/employers/jobs/postjob')->with(compact('salaries', 'Jobs_edit_data', 'subCategories', 'industry', 'Jobfunctionalarea_id', 'career', 'count', 'Filldegreelevel_id', 'get_jobskill', 'Fillskill_id', 'Filllevel_id', 'Fillcity_id', 'jobskill', 'jobTypes', 'degreelevel', 'degreetype', 'Companies', 'city', 'state', 'country', 'functional_area'));
        }
    }



    public function manageapplicationslist(Request $request)
    {
        $company_id    = Auth::guard('candidate')->id();
        if ($request->ajax()) {
            $data =  DB::table('appliedjobs')
                ->select('appliedjobs.*', 'jobs.jobtitle as jobtitle', 'jobs.jobtype as jobtype', 'jobs.company_id as company_id', 'users.name as name')
                ->leftjoin("jobs", "appliedjobs.job_id", "=", "jobs.id")
                ->leftjoin("users", "appliedjobs.candidate_id",  "=", "users.id")
                ->where('company_id', $company_id)
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('name', function ($row) {
                    $jobtitle = $row->jobtitle;
                    return $jobtitle;
                })

                ->addColumn('name', function ($row) {
                    $name =  $row->name;
                    $name =    "<a href=" . route('front_end-candidate_details_view', ['candidate_id' => $row->candidate_id]) .">$row->name</a>";
                    return $name;
                })
                ->addColumn('jobtype', function ($row) {
                    $arrayjobtype = explode(',', $row->jobtype);
                    $jobtype = '';
                    foreach ($arrayjobtype as $typeofjob) {
                        if ($typeofjob == 'fulltime') {
                            $jobtype .= '<nobr><span class="full-time">Full-Time</span></nobr>';
                        } else if ($typeofjob == 'parttime') {
                            $jobtype .= '<nobr><span class="part-time">Part-time</span></nobr>';
                        } else if ($typeofjob == 'freelance') {
                            $jobtype .= '<nobr><span class="freelance">Freelance</span></nobr>';
                        } else if ($typeofjob == 'internship') {
                            $jobtype .= '<nobr><span class="internship">Internship</span></nobr>';
                        } else if ($typeofjob == 'contract') {
                            $jobtype .= '<nobr><span class="contract">Contract</span></nobr>';
                        }
                    }
                    return $jobtype;
                })
                ->addColumn('contact_details', function ($row) {
                    $applied_jobs = Appliedjobs::where('candidate_id', $row->candidate_id)->where('job_id', $row->job_id)->first();
                    $contact_details = isset($applied_jobs->contact_details) ? $applied_jobs->contact_details : '-';
                    return $contact_details;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == '0') {
                        $status = '<p>Rejected</p>';
                    } else if ($row->status == '1') {
                        $status = '<p>Approved</p>';
                    } else if ($row->status == '2') {
                        $status = '<p>Processed</p>';
                    }
                    return $status;
                })

                ->addColumn('created_at', function ($row) {
                    $oldDate = $row->created_at;
                    $newDate = date("F j, Y", strtotime($oldDate));
                    return $newDate;
                })
                ->addColumn('action', function ($row) {
                    $action =
                        '<div class="dropdown float-left">
						<a class="dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-download" style = "color:#111" aria-hidden="true"></i></a>
						<ul class="dropdown-menu pull-right>
							<li><a style ="color:#111; cursor:pointer;">Document List</a></li>
							<li><p><a href=' . route('front_end-employer-candidate-resume-download', ['c_id' => $row->candidate_id]) . ' style ="color:#111; cursor:pointer;"><i class="fa fa-download" aria-hidden="true"></i> Download Resume</a></p></li>
							<li><p><a href=' . route('front_end-employer-candidate-coverletter-download', ['c_id' => $row->candidate_id]) . ' style ="color:#111; cursor:pointer;"><i class="fa fa-download" aria-hidden="true"></i> Download Cover letter</a></p></li>
							<li><p><a href=' . route('front_end-employer-candidate-references-download', ['c_id' => $row->candidate_id]) . ' style ="color:#111; cursor:pointer;"><i class="fa fa-download" aria-hidden="true"></i> Download References</a></p></li>
                            <li><p><a href=' . route('front_end-candidate-attachment-download', ['c_id' => $row->candidate_id , 'job_id' => $row->job_id]) . ' style ="color:#111; cursor:pointer;"><i class="fa fa-download" aria-hidden="true"></i> Download Attachment</a></p></li>
						</ul>
					</div>&nbsp;&nbsp; 
                    <button class="resume" data-toggle="tooltip" title="Reject" onclick="reject_candidate_application(' . $row->job_id . ',' . $row->candidate_id . ')"><i class="fa fa-window-close" aria-hidden="true"></i></button> &nbsp
                    <button class="resume" data-toggle="tooltip" title="Accept" onclick="accept_candidate_application(' . $row->job_id . ',' . $row->candidate_id . ')"><i class="fa fa-check-square" aria-hidden="true"></i></button>';
                    return $action;
                })
                ->rawColumns(['jobtitle', 'status', 'jobtype', 'newDate', 'name', 'action','contact_details'])
                ->make(true);
        }
    }

    public function getSkillLevel()
    {
        $jobskill =  Jobskill::select('id', 'jobskill')->get();
        $career =  Careerlevel::select('id', 'careerlevel')->get();
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

    public function getApplicationsRejectReason(Request $request)
    {   
        $response['status'] = 0;
        $jobId = $request->input('jobid');
        $rejectReasonSql = Jobs::select('reject_reason')->where('id',$jobId)->get()->toArray();
        $rejectReason = '';
        if(!empty($rejectReasonSql)){
            if($rejectReasonSql[0]['reject_reason'] != ''){
                $response['status'] = 1;
                 $rejectReason = $rejectReasonSql[0]['reject_reason'];
                 $response['rejectReason'] = $rejectReason;
            }
        }
        echo json_encode($response);
        exit;

    }

    public function manageapplication_reject(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'subject'              => 'required',
            'description'          => 'required',
        ]);
        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }
        $dataReason = $request->all();
        $company_id    = Auth::guard('candidate')->id();
        $job_id = $dataReason['jobid'];
        $candidate_id = $dataReason['candidate_id']; 
        $description = $dataReason['description']; 
        $subject = $dataReason['subject']; 
        $response['status'] = 0;
        $response['msg'] = "Oops ! Candidate Request not reject !";

        if($dataReason != '' && $dataReason != null){
            $ApplicationRejectReason = new ApplicationRejectReason;
            $ApplicationRejectReason->application_reject_subject            = $subject;
            $ApplicationRejectReason->application_reject_description        = $description;
            $ApplicationRejectReason->job_id                                = $job_id;
            $ApplicationRejectReason->candidate_id                          = $candidate_id;
            $ApplicationRejectReason->created_at                            = Carbon::now(); 
            $ApplicationRejectReason->save();
            $insert_id = $ApplicationRejectReason->id;
        
            $userData =  DB::table('appliedjobs')
                        ->select('appliedjobs.*', 'jobs.jobtitle as jobtitle', 'jobs.jobtype as jobtype', 'jobs.company_id as company_id', 'users.name as name', 'users.email as userEmail')
                        ->leftjoin("jobs", "appliedjobs.job_id", "=", "jobs.id")
                        ->leftjoin("users", "appliedjobs.candidate_id",  "=", "users.id")
                        ->where('company_id', $company_id)
                        ->where('candidate_id', $candidate_id)
                        ->where('job_id', $job_id)
                        ->get();
            $data = [
                'subject'     => $subject,
                'description' => $description,
                'email'       => $userData[0]->userEmail,
                'name'        => $userData[0]->name,
              ];
              
              Mail::send('Front_end.layouts.email_template.application_reject', ["data1" => $data], function ($message) use ($data) {
                $message->to($data['email'])
                ->subject($data['subject']);
              });

            $find_candidate_req = Appliedjobs::where('candidate_id', $candidate_id)->where('job_id', $job_id)->first();
            if ($find_candidate_req->status != 0) {
                $find_candidate_req->status = '0';
                $find_candidate_req->updated_at = Carbon::now();
                $find_candidate_req->save();
                $response['status'] = 1;
                $response['msg'] = "Candidate request reject successfully";
            } else {
                $response['status'] = 0;
                $response['msg'] = "Oops ! Candidate request already rejected !";
            }
        }
        echo json_encode($response);
        exit;
    }

    // public function application_reject_reason(Request $request)
    // {
    //     $validation = Validator::make($request->all(), [
    //         'subject'              => 'required',
    //         'description'          => 'required',
    //     ]);
    //     if ($validation->fails()) {
    //         $data['status'] = 0;
    //         $data['error'] = $validation->errors()->all();
    //         echo json_encode($data);
    //         exit();
    //     }
    //     $dataReason = $request->all();
    //     $response['status'] = 0;
    //     if($dataReason != '' && $dataReason != null){
    //         $response['subject'] = $dataReason['subject'];
    //         $response['status'] = 0;
    //         $response['description'] = $dataReason['description'];
    //     }
    //     echo json_encode($response);
    //     exit;
    // }

    public function manageapplication_accept(Request $request)
    {
        $candidate_id = $request->candidate_id;
        $job_id = $request->jobid;
        $result['status'] = 0;
        $result['msg'] = "Oops ! Candidate Request not accept !";
        if ($candidate_id != '' && $job_id != '') {
            $find_candidate_req = Appliedjobs::where('candidate_id', $candidate_id)->where('job_id', $job_id)->first();
            if ($find_candidate_req->status != 0) {
                $find_candidate_req->status = '1';
                $find_candidate_req->updated_at = Carbon::now();
                $find_candidate_req->save();
                $result['status'] = 1;
                $result['msg'] = "Candidate request accept successfully";
            } else {
                $result['status'] = 0;
                $result['msg'] = "Oops ! Candidate request already rejected !";
            }
        }
        echo json_encode($result);
        exit;
    }
}
