<?php

namespace App\Http\Controllers\Front_end;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Models\Country;
use App\Models\PopularSearch;
use App\Models\Setting;
use App\Models\Industries;
use App\Models\Jobs;
use App\Models\Cms;
use App\Models\Functional_area;
use App\Models\Blogs;
// use Cms;
use Illuminate\Support\Facades\Auth;
use DB;    
    
class HomeController extends Controller
{    

    public function index() {
        
        $sql = DB::table('jobs')
                ->select('jobs.*','functional_area.functional_area','companies.location','companies.companyname','country.country_name','wishlist.id as wishlist_id')
                ->join('functional_area', 'functional_area.id', '=', 'jobs.functional_id')
                ->join('companies', 'companies.id', '=', 'jobs.company_id')
                ->join('country', 'country.id', '=', 'jobs.country_id') 
                ->where('jobs.status','1');      
        $sql->leftjoin('wishlist', function($join) {        
            $join->on('jobs.id','=', "wishlist.job_id");         
            $join->where("wishlist.candidate_id" , Auth::guard('candidate')->id());
        });     
        $AllactiveJobs = $sql->get()->toArray();      
        $totalJobs = DB::table('jobs')->where('status',1)->get()->toArray();
        
        $activeJobs    = $sql->take(6)->latest()->get()->toArray();   
        // $AllactiveJobs = $sql->get()->toArray();      
        
        //echo '<pre>'; print_r($activeJobs); exit;                   
        $activeCompanies = DB::table('companies')
                ->select('*')
                ->where('status','1')
                ->get();  

        $activeBlogs = DB::table('blogs')
                ->select('*')
                ->where('status','1')
                ->orderBy("updated_at", "desc")
                ->take(3)
                ->get()->toArray();

        $activePackages = DB::table('package')
                ->select('*')
                ->where('status','1')
                ->get()->toArray();                           

        $ActivehomeCategory = Industries::where('status',1)->where('is_default','yes')->orderBy("updated_at", "desc")->take(8)->get()->toArray();
        

        $homeCategoryIcon = array('lni-home','lni-world','lni-book','lni-display','lni-brush','lni-heart','lni-funnel','lni-cup');
        $category = [];  
        $jobs = [];
        $ActivehomeCategoryJobs = [];
        if(!empty($activeJobs)) {
            foreach($ActivehomeCategory as $homeCategoryKey => $homeCategoryValue) {
                $count = 0;
                $ActivehomeCategoryJobs = array();
                $ActivehomeCategoryJobs[] = Jobs::where('status',1)->where('industry_id',$homeCategoryValue['id'])->get()->toArray();
                
                
                // foreach ($activeJobs as $key => $value) {
                //     if(in_array($value->industry_id,$homeCategoryValue['id'])) {
                //         $count++;
                //         $category[$value->industry_id]['count'] = $count;    
                //     } 
                // }    
                // if($count == 0) {
                //     // $category[$homeCategoryValue]['count'] = 0;
                // }
            }
        }

        // country list for job Search
        $country = Country::select('id', 'country_name')->where('status',1)->get();
        $popularSearch = PopularSearch::select('id', 'popular_search')->where('status',1)->orderBy('id', 'DESC')->take(4)->get();
        $setting = Setting::select()->first();
        
    	return view('Front_end/layouts/home/homeindex')->with(compact('totalJobs','country','setting','activeJobs','popularSearch','AllactiveJobs','activeCompanies','ActivehomeCategoryJobs','ActivehomeCategory','homeCategoryIcon','category','activeBlogs','activePackages'));
    	// return view('Front_end.layouts.home.homeindex')->with(compact('setting'));
    }  

    public function clearCache() {
        // Artisan::call('debugbar:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        echo "clear";
    }

    public  function findavailablejobs(Request $request)
    {
        $data = $request->all();
        $search = $data['search_jobs'];
        $search_country = $data['country'];                      
    }

    public function blog_details($blogId = null){
        $blogData = Blogs::where('id',$blogId)->first();
        $allBlog = Blogs::select()->take(10)->get()->toArray();
        return view('Front_end/layouts/home/home_page/blog_details')->with(compact('blogData','allBlog'));
    }

    public function new_cms_page($cms_slug = null){
        $cmsData = Cms::where('slug',$cms_slug)->first();
        return view('Front_end/layouts/home/cms_pages')->with(compact('cmsData'));
    }

}