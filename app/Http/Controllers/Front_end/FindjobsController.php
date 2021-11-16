<?php

namespace App\Http\Controllers\Front_end;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appliedjobs;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Models\Industries;
use App\Models\Jobs;
use App\Models\Wishlist;
use DB;


class FindjobsController extends Controller
{
    public function candidate_appliedjobs(Request $request)
    {
        $request->validate([
            'con_number'     => 'required',
            'apply_attachment'  => 'mimes:pdf,doc,docx|max:2048',
        ]);
        
        $job_id = $request->job_id;
        $con_number = $request->con_number;
        $response['status'] = 0;
        $response['msg'] = "You have already Applied for this job!";
        $apply_attachment_name = '';
        $candidate_id   = Auth::guard('candidate')->id();
        $Appliedjobs    = new Appliedjobs();
        $find_candidate = Appliedjobs::where('candidate_id', $candidate_id)
            ->where('job_id', $job_id)
            ->get();
        $result = $find_candidate->count();
        if ($result == 0) {
            if(!is_dir(public_path('assets/front_end/Upload/apply_job_attachment'))){       
                mkdir(public_path('assets/front_end/Upload/apply_job_attachment'), 0777, true);
            }
            
            if($request->apply_attachment != ''){
                $apply_attachment_name = time().'.'.$request->apply_attachment->extension();  
                $request->apply_attachment->move(public_path('assets/front_end/Upload/apply_job_attachment'), $apply_attachment_name);
            }
            
            if ($candidate_id != '' && $job_id != '') {
                $Appliedjobs->candidate_id     = $candidate_id;
                $Appliedjobs->job_id           = $job_id;
                $Appliedjobs->contact_details  = $con_number;
                $Appliedjobs->document         = $apply_attachment_name;
                $Appliedjobs->save();
                $response['status'] = 1;
                $response['msg'] = 'Job Applied Successfully';
            }
        }
        echo json_encode($response);
        exit;
    }

    public function candidate_findjobs_view(Request $request, $Category_id = null)
    {
        $home_country = isset($_GET['home_country']) ? $_GET['home_country'] : '';
        $home_search = isset($_GET['home_search']) ? $_GET['home_search'] : '';
        $home_category = isset($_GET['home_category']) ? $_GET['home_category'] : '';
        $find_candidate = '';

        $data = $request->all();
        
        $search = isset($data['search_jobs']) ? $data['search_jobs'] : '';
        if ($search == '') {
            $search = $home_search;
        }
        $search_country = isset($data['country']) ? $data['country'] : '';
        if ($search_country == '') {
            $search_country = $home_country;
        }
        // $search_country = isset($data['country']) ? $data['country'] : '';
        // if ($search_country == '') {
        //     $search_country = $home_country;
        // }
        $candidate_id  = Auth::guard('candidate')->id();
        if ($search == '' && $search_country == '' ) {
            $query = DB::table('jobs')
                ->select('jobs.*', 'country.country_name as country', 'state.state_name as state', 'companies.companyname as companyname', 'companies.companylogo as companylogo', 'wishlist.id as wishlist_id')
                ->leftjoin("country", "jobs.country_id", "=", "country.id")
                ->leftjoin("state", "jobs.state_id", "=", "state.id")
                ->leftjoin("companies", "jobs.company_id", "=", "companies.id");

            $query->leftjoin('wishlist', function ($join) {
                $join->on('jobs.id', '=', "wishlist.job_id");
                $join->where("wishlist.candidate_id", Auth::guard('candidate')->id());
            });
            if ($Category_id != '' && $Category_id != null) {
                $query->where('jobs.industry_id', $Category_id);
            }
            $numberOfRecord = count($query->get());
            $data = $query->paginate(4);
            // if($data[0]->id != '' && $data[0]->id != null){
            //     // $find_candidate = DB::table('appliedjobs')
            //     //                 ->select('appliedjobs.*')
            //     //                 ->where('candidate_id', Auth::guard('candidate')->id())
            //     //                 ->where('job_id', $data[0]->id)
            //     //                 ->first();
            // }
            // $data = $query->get()->toArray();
        } else {
            $data = DB::table('jobs')
                ->select('jobs.*', 'country.country_name as country', 'state.state_name as state', 'companies.companyname as companyname', 'companies.companylogo as companylogo', 'wishlist.id as wishlist_id', 'industries.industry_name as category')
                ->leftjoin("country", "jobs.country_id", "=", "country.id")
                ->leftjoin("state", "jobs.state_id", "=", "state.id")
                ->leftjoin("companies", "jobs.company_id", "=", "companies.id")
                ->leftjoin("industries", "jobs.industry_id", "=", "industries.id");
                // ->leftjoin("functional_area", "jobs.industry_id", "=", "functional_area.industry_id")

            $data->leftjoin('wishlist', function ($join) {
                $join->on('jobs.id', '=', "wishlist.job_id");
                $join->where("wishlist.candidate_id", Auth::guard('candidate')->id());
            });
            if ($search_country > 0) {
                $data->where('jobs.country_id', $search_country);
            }
            if ($Category_id != '' && $Category_id != null) {
                $data->where('jobs.industry_id', $Category_id);
            }
            $data->where(function ($query) use ($search) {
                $query->where('jobs.jobtitle', "like", "%" . $search . "%");
                $query->orWhere('companyname', "like", "%" . $search . "%");
                $query->orWhere('industries.industry_name', "like", "%" . $search . "%");
                // $query->orWhere('functional_area.functional_area', "like", "%" . $search . "%");
            });
            $numberOfRecord = count($data->get());
            // echo "<pre>";
            // print_r($data->get());
            // die;
            $data = $data->paginate(4);

            // if($data[0]->id != '' && $data[0]->id != null){
            //         $find_candidate = DB::table('appliedjobs')
            //                             ->select('appliedjobs.*')
            //                             ->where('candidate_id', Auth::guard('candidate')->id())
            //                             ->where('job_id', $data[0]->id)
            //                             ->first();   
            // }    

        }
        $country = Country::select('id', 'country_name')->where('status', '1')->get();
        $categories = Industries::select('id', 'industry_name')->where('status', '1')->get();

        return view('Front_end.candidate.findJobs')->with(compact('numberOfRecord','country', 'home_country', 'home_search', 'data', 'find_candidate', 'categories', 'home_category'));
    }
    public  function candidate_findjobs(Request $request)
    {
        
        $data = $request->all();
        
        $search = isset($data['search_jobs']) ? $data['search_jobs'] : '';
        $search_country = isset($data['country']) ? $data['country'] : '';
        $search_category = isset($data['category']) ? $data['category'] : '';
        $candidate_id  = Auth::guard('candidate')->id();
        $find_candidate = '';

        if ($search == '' && $search_country == '' && $search_category == '') {

            $query = DB::table('jobs')
                ->select('jobs.*', 'country.country_name as country', 'state.state_name as state', 'companies.companyname as companyname', 'companies.companylogo as companylogo', 'wishlist.id as wishlist_id')
                ->leftjoin("country", "jobs.country_id", "=", "country.id")
                ->leftjoin("state", "jobs.state_id", "=", "state.id")
                ->leftjoin("companies", "jobs.company_id", "=", "companies.id");
            $query->leftjoin('wishlist', function ($join) {
                $join->on('jobs.id', '=', "wishlist.job_id");
                $join->where("wishlist.candidate_id", Auth::guard('candidate')->id());
            });
            $data = $query->paginate(4);
        } else {
            $data = DB::table('jobs')
                ->select('jobs.*', 'country.country_name as country', 'state.state_name as state',
                         'industries.industry_name as category',
                          'companies.companyname as companyname', 'companies.companylogo as companylogo', 
                          'wishlist.id as wishlist_id')
                ->leftjoin("country", "jobs.country_id", "=", "country.id")
                ->leftjoin("industries", "jobs.industry_id", "=", "industries.id")
                ->leftjoin("state", "jobs.state_id", "=", "state.id")
                ->leftjoin("companies", "jobs.company_id", "=", "companies.id");
            $data->leftjoin('wishlist', function ($join) {
                $join->on('jobs.id', '=', "wishlist.job_id");
                $join->where("wishlist.candidate_id", Auth::guard('candidate')->id());
            });
            if ($search_country != '') {
                $data->where('jobs.country_id', $search_country);
            }
            if ($search_category != '') {
                $data->where('jobs.industry_id', $search_category);
            }
            $data->where(function ($query) use ($search) {
                $query->where('jobs.jobtitle', "like", "%" . $search . "%");
                $query->orWhere('companyname', "like", "%" . $search . "%");
            });
            

            $data = $data->paginate(4);
        }
        

        return view('Front_end.candidate.findjobsrender', compact('data', 'find_candidate'))->render();
    }
    function get_data_on_scroll(Request $request)
    {
        $data = $request->all();

        $search = isset($data['search_jobs']) ? $data['search_jobs'] : '';
        $search_country = isset($data['country']) ? $data['country'] : '';
        $search_category = isset($data['category']) ? $data['category'] : '';
        $candidate_id  = Auth::guard('candidate')->id();
        $find_candidate = '';

        if ($search == '' && $search_country == '' && $search_category == '') {

            $query = DB::table('jobs')
                ->select('jobs.*', 'country.country_name as country', 'state.state_name as state', 'companies.companyname as companyname', 'companies.companylogo as companylogo', 'wishlist.id as wishlist_id')
                ->leftjoin("country", "jobs.country_id", "=", "country.id")
                ->leftjoin("state", "jobs.state_id", "=", "state.id")
                ->leftjoin("companies", "jobs.company_id", "=", "companies.id");
            $query->leftjoin('wishlist', function ($join) {
                $join->on('jobs.id', '=', "wishlist.job_id");
                $join->where("wishlist.candidate_id", Auth::guard('candidate')->id());
            });
      
            $numberOfRecord = count($query->get());
            $data = $query->paginate(4);
            // echo '<pre>';
            // print_r($data);
            // die;
        } else {

            $data = DB::table('jobs')
                ->select('jobs.*', 'country.country_name as country', 'state.state_name as state', 'functional_area.functional_area as subcategory', 'companies.companyname as companyname', 'companies.companylogo as companylogo', 'wishlist.id as wishlist_id')
                ->leftjoin("country", "jobs.country_id", "=", "country.id")
                ->leftjoin("functional_area", "jobs.industry_id", "=", "functional_area.industry_id")
                ->leftjoin("state", "jobs.state_id", "=", "state.id")
                ->leftjoin("companies", "jobs.company_id", "=", "companies.id");
            $data->leftjoin('wishlist', function ($join) {
                $join->on('jobs.id', '=', "wishlist.job_id");
                $join->where("wishlist.candidate_id", Auth::guard('candidate')->id());
            });
            if ($search_country > 0) {
                $data->where('jobs.country_id', $search_country);
            }
            if ($search_category > 0) {
                $data->where('jobs.industry_id', $search_category);
            }
            $data->where(function ($query) use ($search) {
                $query->where('jobs.jobtitle', "like", "%" . $search . "%");
                $query->orWhere('companyname', "like", "%" . $search . "%");
            });
            $numberOfRecord = count($data->get());
            $data = $data->paginate(4);
        }
        
        $view = view('Front_end.candidate.loadjobdetails', compact('data', 'data','numberOfRecord'))->render();
        echo json_encode($view);
        exit;
    }

    //     public  function candidate_findjobs(Request $request){
    //        $data = $request->all();
    //        $search = isset($data['search_jobs']) ? $data['search_jobs'] : '';
    //        $search_country = isset($data['country']) ? $data['country'] : '';
    //        $candidate_id  = Auth::guard('candidate')->id();
    //        $find_candidate = '';

    //        if($search == '' && $search_country == ''){
    //         $query = DB::table('jobs')
    //         ->select('jobs.*', 'country.country_name as country', 'state.state_name as state', 'companies.companyname as companyname','wishlist.id as wishlist_id')
    //         ->leftjoin("country", "jobs.country_id", "=", "country.id")
    //         ->leftjoin("state", "jobs.state_id", "=", "state.id")
    //         ->leftjoin("companies", "jobs.company_id", "=", "companies.id");
    //         $query->leftjoin('wishlist', function($join){
    //             $join->on('jobs.id','=', "wishlist.job_id");
    //             $join->where("wishlist.candidate_id" , Auth::guard('candidate')->id());
    //         });
    //         $data = $query->paginate(5);    
    //                 // $data = $query->get()->toArray();
    //         if($data[0]->id != '' && $data[0]->id != null){
    //                 $find_candidate = DB::table('appliedjobs')
    //                                 ->select('appliedjobs.*')
    //                                 ->where('candidate_id', Auth::guard('candidate')->id())
    //                                 ->where('job_id', $data[0]->id)
    //                                 ->first();
    //         }
    //     }else{
    //         $query = DB::table('jobs');
    //         if($search_country > 0){
    //             $query ->select('jobs.*', 'country.country_name as country', 'state.state_name as state', 'companies.companyname as companyname','wishlist.id as wishlist_id');
    //         }
    //         $query  ->select('jobs.*', 'country.country_name as country', 'state.state_name as state', 'companies.companyname as companyname');
    //         $query   ->leftjoin("country", "jobs.country_id", "=", "country.id")
    //                         // ->leftjoin("city", "jobs.city_id",  "=", "city.id")
    //                 ->leftjoin("state", "jobs.state_id", "=", "state.id")
    //                 ->leftjoin("companies", "jobs.company_id", "=", "companies.id");
    //                 if($search_country > 0){
    //                     $query    ->where('jobs.country_id', $search_country);
    //                 }
    //                         // $query       ->where('jobs.country_id', $search_country)
    //                 $query   ->where(function ($query) use ($search) {
    //                     $query->where('jobs.jobtitle', "like", "%" . $search . "%");
    //                     $query->orWhere('companyname', "like", "%" . $search . "%");
    //                 });
    //                 $query->leftjoin('wishlist', function($join){
    //                     $join->on('jobs.id','=', "wishlist.job_id");
    //                     $join->where("wishlist.candidate_id" , Auth::guard('candidate')->id());
    //                 })->get()->toArray();
    //         $data = $query->paginate(5); 


    //                 // if(isset($data[0]->id)){
    //                 //     $find_candidate = DB::table('appliedjobs')
    //                 //                     ->select('appliedjobs.*')
    //                 //                     ->where('candidate_id', Auth::guard('candidate')->id())
    //                 //                     ->where('job_id', $data[0]->id)
    //                 //                     ->first();
    //                 // }
    //                         // ->get()->toArray();
    //     }
    //     return view('Front_end.candidate.findjobsrender',compact('data','find_candidate'))->render();    
    // }


    public function job_details_view($job_id)
    {
   
        // $job_details = Jobs::where('id', $job_id)
        $job_details =   DB::table('jobs')
            ->select('jobs.*', 'country.country_name as country', 'state.state_name as state', 'companies.companyname as companyname', 'companies.googlemap as googlemap', 'salary.salary as salary')
            ->leftjoin("country", "jobs.country_id", "=", "country.id")
            ->leftjoin("state", "jobs.state_id", "=", "state.id")
            ->leftjoin("companies", "jobs.company_id", "=", "companies.id")
            ->leftjoin("salary", "jobs.salaryfrom", "=", "salary.id")
            ->where('jobs.id', $job_id)
            ->first();
        $job_city = DB::table('jobs_city')
            ->select('jobs_city.*', 'city.city_name as city')
            ->leftjoin("city", "jobs_city.city_id",  "=", "city.id")
            ->where('jobs_city.job_id', $job_id)
            ->get();
        $job_skill = DB::table('job_skill_level')
            ->select('job_skill_level.*', 'jobskill.jobskill as jobskill')
            ->leftjoin("jobskill", "job_skill_level.skill_id",  "=", "jobskill.id")
            ->where('job_skill_level.job_id', $job_id)
            ->get();
        $find_candidate = DB::table('appliedjobs')
            ->select('appliedjobs.*')
            ->where('candidate_id', Auth::guard('candidate')->id())
            ->where('job_id', $job_id)
            ->first();

        // $result = $job_details->count();
        if (!empty($job_details)) {
            return view('Front_end.candidate.jobdetails')->with(compact('job_details', 'job_city', 'job_skill', 'job_id', 'find_candidate'));
        } else {
            return redirect()->back()->with('error', 'Job Details not Found');
        }
    }
    public function getJobDetails(Request $request)
    {
        $job_id = $request->post('job_id');

        // $job_details = Jobs::where('id', $job_id)
        $data['job_details'] =   DB::table('jobs')
            ->select('jobs.*', 'country.country_name as country', 'state.state_name as state', 'companies.companyname as companyname', 'companies.companylogo as companylogo', 'companies.googlemap as googlemap', 'salary.salary as salary')
            ->leftjoin("country", "jobs.country_id", "=", "country.id")
            ->leftjoin("state", "jobs.state_id", "=", "state.id")
            ->leftjoin("companies", "jobs.company_id", "=", "companies.id")
            ->leftjoin("salary", "jobs.salaryfrom", "=", "salary.id")
            ->where('jobs.id', $job_id)
            ->first();
        $data['job_city'] = DB::table('jobs_city')
            ->select('jobs_city.*', 'city.city_name as city')
            ->leftjoin("city", "jobs_city.city_id",  "=", "city.id")
            ->where('jobs_city.job_id', $job_id)
            ->get();
        $data['job_skill'] = DB::table('job_skill_level')
            ->select('job_skill_level.*', 'jobskill.jobskill as jobskill')
            ->leftjoin("jobskill", "job_skill_level.skill_id",  "=", "jobskill.id")
            ->where('job_skill_level.job_id', $job_id)
            ->get();
        $data['find_candidate'] = DB::table('appliedjobs')
            ->select('appliedjobs.*')
            ->where('candidate_id', Auth::guard('candidate')->id())
            ->where('job_id', $job_id)
            ->first();

        // echo '<pre>';
        // print_r($job_details->salary);
        // die;
        //     $view = '<div class="card bg-light">
        //     <div class="card-body">
        //     <div class="details_header">
        //     <div class="companyface">
        //     <img class="img-thumbnail" src="'.asset("assets/front_end/images/noimage.jpg").'" style="width: 20%;float:left;margin-right:10px;object-fit: cover" />
        //     </div>
        //     </div>
        //     </div>
        //   </div>';
        $view = view('Front_end.candidate.new_jobdetails', compact('data', 'data'))->render();
        // echo '<pre>';
        // print_r($view);
        // die;
        // $result = $job_details->count();
        if (!empty($data['job_details'])) {
            echo json_encode($view);
            exit;
        }
    }

    public function job_makefavourite(Request $request)
    {
        $job_id = $request->job_id;
        $response['status'] = 0;
        $candidate_id  = Auth::guard('candidate')->id();
        $Wishlist    = new Wishlist();
        $find_candidate = Wishlist::where('candidate_id', $candidate_id)
            ->where('job_id', $job_id)
            ->get();
        $result = $find_candidate->count();
        if ($result == 0) {
            if ($candidate_id != '' && $job_id != '') {
                $Wishlist->candidate_id     = $candidate_id;
                $Wishlist->job_id           = $job_id;
                $Wishlist->save();
                $response['status'] = 1;
            }
        }
        echo json_encode($response);
        exit;
    }

    public function job_removefavourite(Request $request)
    {
        $job_id = $request->job_id;
        $response['status'] = 0;
        $candidate_id  = Auth::guard('candidate')->id();
        $Wishlist    = new Wishlist();
        $find_candidate = Wishlist::where('candidate_id', $candidate_id)
            ->where('job_id', $job_id)
            ->first();
        if (!empty($find_candidate)) {
            $del_sql = Wishlist::where('id', $find_candidate->id)->delete();
            $response['status'] = 1;
        }
        echo json_encode($response);
        exit;
    }
}
