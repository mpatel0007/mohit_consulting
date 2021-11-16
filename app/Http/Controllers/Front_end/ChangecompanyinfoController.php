<?php

namespace App\Http\Controllers\Front_end;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\Companies;
use App\Models\Industries;
use App\Models\City;
use App\Models\State;
use App\Models\Companycity;
use App\Models\Companyindustry;
use App\Models\Companyfunctionalarea;
use App\Models\Functional_area;
use App\Models\Country;
use App\Models\Package;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use DataTables;
use App\Helper\Helper;
 

class ChangecompanyinfoController extends Controller{


    public function companyprofile_view(Request $request){
        // echo "sdsdsd"; die;
        Helper::isEmployers();
        $company_id   = Auth::guard('candidate')->id();     
        if(!empty($company_id)){
            $edit_sql = Companies::where('user_id',$company_id)->first();
    
            if(!empty($edit_sql)){
                // $Companyindustry = Companyindustry::where('company_id',$company_id)->get()->toArray();
                // $Companyindustry_id = array();
                // foreach($Companyindustry as $industry_id)
                // {
                //     $Companyindustry_id[] =  $industry_id['industry_id'];
                // }
                $Companyfunctionalarea = Companyfunctionalarea::where('company_id',$company_id)->get()->toArray();
                    $Companyfunctionalarea_id = array();
                    foreach($Companyfunctionalarea as $functionalarea_id)
                    {
                        $Companyfunctionalarea_id[] =  $functionalarea_id['functional_area_id'];
                    }
                $Companycitys = Companycity::where('company_id',$company_id)->get()->toArray();
                $Fillcity_id = array();
                foreach($Companycitys as $city_id)
                {
                    $Fillcity_id[] =  $city_id['city_id'];
                }
                $Companies_edit_data = $edit_sql;
                $industry = Industries::select('id','industry_name')->get();
                $country = Country::select('id','country_name')->get();
                $selected_country = $Companies_edit_data->country_id;
                $selected_state = $Companies_edit_data->state_id;
                $state = State::where('country_id',$selected_country)->get();
                $city = City::where('state_id',$selected_state)->get();
                $subCategories = Functional_area::where('industry_id',$Companies_edit_data->industry_id)->get();
                $package = Package::where('package_for', 0)
                                ->where('status',1)
                                ->get();    
                return view('Front_end/employers/jobs/change_company_info')->with(compact('Companies_edit_data','subCategories','Companyfunctionalarea_id','Fillcity_id','package','industry','city','state','country'));
            }
        }
    }

    public function companyprofile_proccess(Request $request){
        Helper::isEmployers();
        $validation = Validator::make($request->all(), [
            'companyname'             => 'required',
        // 'password'                => 'required',
        // 'companyseo'              => 'required',
            'industry'                => 'required',
        // 'ownershiptype'           => 'required',
            'companydetail'           => 'required',
        // 'location'                => 'required',
        // 'numberofoffices'         => 'required',
        // 'googlemap'               => 'required',
        // 'establishedin'           => 'required',
        // 'phone'                   => 'required',
            'country'                 => 'required',
            'state'                   => 'required',
            'city'                    => 'required',
        // 'package'                 => 'required',
        // 'status'                  => 'required',
        ]);
        $update_id = $request->input('hid');        
        if(empty($update_id)){
            $validation->password       = 'required';
            $validation->companyemail   = 'required|email|unique:companies';
        } 

        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }
        $update_id = $request->input('hid');  
        $CompanyData = $request->all();

    // File upload companylogo
        // $image = $request->file('companylog');
        // if(!empty($image)){
        //     $image_name = time().'.'.$image->getClientOriginalExtension();        
        //     $destinationPath = public_path('assets/admin/companylogosImg/');
        //     $image_resize = Image::make($image->getRealPath());              
        //     $image_resize->resize(300,200);
        //     if(!empty($image_name)){
        //         $image_resize->save($destinationPath . $image_name,80);
        //     }
        // }

        $result['status'] = 0;
        $result['msg'] = "Please enter valid data";
        $company_id    = Auth::guard('candidate')->id();
        $UpdateDetails = Companies::where('user_id',$company_id)->first();
        // $UpdateDetails->companylogo       = !empty($image_name) ? $image_name : $UpdateDetails->companylogo;
        $UpdateDetails->companyname       = $CompanyData['companyname'];
        $UpdateDetails->ownershiptype     = $CompanyData['ownershiptype'];
        $UpdateDetails->companyemail      = $CompanyData['companyemail'];
        $UpdateDetails->companydetail     = $CompanyData['companydetail'];
        $UpdateDetails->location          = $CompanyData['location'];
        $UpdateDetails->googlemap         = $CompanyData['googlemap'];
        $UpdateDetails->numberofoffices   = $CompanyData['numberofoffices'];
        $UpdateDetails->website           = $CompanyData['website'];
        $UpdateDetails->numberofemployees = $CompanyData['numberofemployees'];
        $UpdateDetails->establishedin     = $CompanyData['establishedin'];
        $UpdateDetails->fax               = $CompanyData['fax'];
        $UpdateDetails->phone             = $CompanyData['phone'];
        $UpdateDetails->facebook          = $CompanyData['facebook'];
        $UpdateDetails->twitter           = $CompanyData['twitter'];
        $UpdateDetails->linkedin          = $CompanyData['linkedin'];
        $UpdateDetails->google            = $CompanyData['google'];
        $UpdateDetails->pinterest         = $CompanyData['pinterest'];
        $UpdateDetails->industry_id         = $CompanyData['industry'];
        $UpdateDetails->country_id        = $CompanyData['country'];
        $UpdateDetails->state_id          = $CompanyData['state'];
        $UpdateDetails->save();
        $result['status'] = 1;
        $result['msg'] = "Company Information Updated successfully";
        if($company_id != '' && $company_id != null){
            $del_Companycity      = Companycity::where('company_id',$company_id)->delete();
            // $del_Companyindustry  = Companyindustry::where('company_id',$company_id)->delete();
            $del_Companyfunctionalarea  = Companyfunctionalarea::where('company_id',$company_id)->delete();

            // $Company_industry =  $CompanyData['industry'];
            // if($Company_industry != '' && $Company_industry != null ){
            //     foreach ($Company_industry as $key => $industry_id) {
            //         $Companyindustry = new Companyindustry();   
            //         $Companyindustry->company_id       = $company_id;
            //         $Companyindustry->industry_id      = $industry_id;
            //         $Companyindustry->save();
            //     }
            // }        
            $Company_functionalarea =  $CompanyData['subCategory'];
            if($Company_functionalarea != '' && $Company_functionalarea != null ){
                foreach ($Company_functionalarea as $key => $functional_area_id) {
                    $Companyfunctionalarea = new Companyfunctionalarea();   
                    $Companyfunctionalarea->company_id              = $company_id;
                    $Companyfunctionalarea->functional_area_id      = $functional_area_id;
                    $Companyfunctionalarea->save();
                }
            }
            $city_ids = $CompanyData['city'];       
            if($city_ids != '' && $city_ids != null ){
                foreach ($city_ids as $city_id) {
                    $insert_city = new Companycity();   
                    $insert_city->city_id       = $city_id;
                    $insert_city->company_id    = $company_id;
                    $insert_city->save();
                }
            }
        }
        echo json_encode($result);
        exit;
    }

    public function employers_profile_image(Request $request){
        Helper::isEmployers();
        $result['status'] = 0;
        $result['msg'] = "Oops ! Profile Image not updated !";

        $validation = Validator::make($request->all(), [
            'croppedImageDataURL'             => 'required',    
        ]);
        if ($validation->fails()) {
            $result['status'] = 0;
            $result['error'] = $validation->errors()->all();
            echo json_encode($result);
            exit();
        }
 
        $company_id    = Auth::guard('candidate')->id();
        $Companies = Companies::where('user_id',$company_id)->first();
        $Companies->companylogo = $request->croppedImageDataURL;
        $Companies->save();
        if($Companies){
            $result['status'] = 1;
            $result['msg'] = "Profile Image updated Successfully !";
        }
        echo json_encode($result);
        exit;
    }
}


