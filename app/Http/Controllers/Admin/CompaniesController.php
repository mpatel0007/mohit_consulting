<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\Companies;
use App\Models\Industries;
use App\Models\City;
use App\Models\State;
use App\Models\Companycity;
use App\Models\Functional_area;
use App\Models\Companyindustry;
use App\Models\Companyfunctionalarea;
use App\Models\Country;
use App\Models\Package;
use App\Models\Userprofile;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator; 
use DataTables;


class CompaniesController extends Controller
{
    public function companiesform()
    {
        $industry = Industries::select('id','industry_name')->get();
        $country = Country::select('id','country_name')->get();
        $Users = Userprofile::select('id','name')->where('is_company','!=',1)->get();
        // $subCategories = Functional_area::select('id','functional_area')->get();
        // $package = Package::select('id','package_title')->get();
        // $package = Package::select('id','package_title','status','package_for')->get();
        $package = Package::where('package_for', 0)
        ->where('status',1)
        ->get();    

        return view('Admin/companies/addcompanyform')->with(compact('package','country','industry','Users'));
    }

    public function addcompany(Request $request){
        try {
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
            $image_name = $request->croppedImageDataURL; 
            
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
            $Companies = new Companies();
            if($update_id == '' && $update_id == null){
                $Companies->companylogo       = !empty($image_name) ? $image_name : " ";
                $Companies->user_id           = $CompanyData['User'];
                $Companies->companyname       = $CompanyData['companyname'];
                $Companies->companyemail      = $CompanyData['companyemail'];
                $Companies->password          = Hash::make($CompanyData['password']);
            // $Companies->companyseo        = $CompanyData['companyseo'];
                $Companies->industry_id       = $CompanyData['industry'];
                $Companies->ownershiptype     = $CompanyData['ownershiptype'];
                $Companies->companydetail     = $CompanyData['companydetail'];
                $Companies->location          = $CompanyData['location'];
                $Companies->googlemap         = $CompanyData['googlemap'];
                $Companies->numberofoffices   = $CompanyData['numberofoffices'];
                $Companies->website           = $CompanyData['website'];
                $Companies->numberofemployees = $CompanyData['numberofemployees'];
                $Companies->establishedin     = $CompanyData['establishedin'];
                $Companies->fax               = $CompanyData['fax'];
                $Companies->phone             = $CompanyData['phone'];
                $Companies->facebook          = $CompanyData['facebook'];
                $Companies->twitter           = $CompanyData['twitter'];
                $Companies->linkedin          = $CompanyData['linkedin'];
                $Companies->google            = $CompanyData['google'];
                $Companies->pinterest         = $CompanyData['pinterest'];
                $Companies->country_id        = $CompanyData['country'];
                $Companies->state_id          = $CompanyData['state'];
                // $Companies->city_id           = $CompanyData['city'];
                $Companies->package_id        = $CompanyData['package'];
                $Companies->status            = $CompanyData['status'];
                $Companies->save();
                $insert_id = $Companies->id;
                if($insert_id != '' && $insert_id != null){
                    $UpdateDetails = Userprofile::where('id',$CompanyData['User'])->first();
                    $UpdateDetails->is_company   =  1;
                    $UpdateDetails->save();
                }
                if($insert_id > 0) {
                    $result['status'] = 1;
                    $result['msg'] = "Company inserted successfully";
                }
                if($insert_id != '' && $insert_id != null){
                    $Company_functionalarea =  $CompanyData['subCategory'];
                    if($Company_functionalarea != '' && $Company_functionalarea != null ){
                        foreach ($Company_functionalarea as $key => $functional_area_id) {
                            $Companyfunctionalarea = new Companyfunctionalarea();   
                            $Companyfunctionalarea->company_id              = $CompanyData['User'];
                            $Companyfunctionalarea->functional_area_id      = $functional_area_id;
                            $Companyfunctionalarea->save();
                        }
                    }
                    $city_ids = $CompanyData['city'];       
                    if($city_ids != '' && $city_ids != null ){
                        foreach ($city_ids as $city_id) {
                            $insert_city = new Companycity();   
                            $insert_city->city_id       = $city_id;
                            $insert_city->company_id    = $CompanyData['User'];
                            $insert_city->save();
                        }
                    }

                    // stripe data
                    /*DB::table('subscriptions')->insert([
                        'user_id' => $CompanyData['User'],
                        'stripe_id' =>'Admin',
                        'stripe_price'=>$packagePrice,  
                        'quantity' => '1',
                        'name'=> $id,
                        'stripe_status'=>1,
                        'candidate'=>1,        
                        'start_at'=>$subscriptionStartDate,
                        'ends_at'=>$subscriptionEndDate,
                        'created_at'=>$mytime
                    ]);*/

                }
            }else{

                $UpdateDetails = Companies::where('id',$update_id)->first();

                $UpdateDetails->companylogo       = !empty($image_name) ? $image_name : $UpdateDetails->companylogo;
                $UpdateDetails->companyname       = $CompanyData['companyname'];
                $UpdateDetails->companyemail      = $CompanyData['companyemail'];
                $UpdateDetails->password          = !empty($CompanyData['password']) ? Hash::make($CompanyData['password']) : $UpdateDetails->password;
            // $UpdateDetails->companyseo        = $CompanyData['companyseo'];
                $UpdateDetails->industry_id       = $CompanyData['industry'];
                $UpdateDetails->ownershiptype     = $CompanyData['ownershiptype'];
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
                $UpdateDetails->country_id        = $CompanyData['country'];
                $UpdateDetails->state_id          = $CompanyData['state'];
            // $UpdateDetails->city_id           = $CompanyData['city'];
                $UpdateDetails->package_id        = $CompanyData['package'];
                $UpdateDetails->status            = $CompanyData['status'];
                $UpdateDetails->save();
                $result['status'] = 1;
                $result['msg'] = "Company Updated successfully";
                if($update_id != '' && $update_id != null){
                    $del_Companycity      = Companycity::where('company_id',$UpdateDetails->user_id)->delete();
                    $del_Companyfunctionalarea  = Companyfunctionalarea::where('company_id',$UpdateDetails->user_id)->delete();

                    // $Company_industry =  $CompanyData['industry'];
                    // if($Company_industry != '' && $Company_industry != null ){
                    //     foreach ($Company_industry as $key => $industry_id) {
                    //         $Companyindustry = new Companyindustry();   
                    //         $Companyindustry->company_id       = $UpdateDetails->user_id;
                    //         $Companyindustry->industry_id      = $industry_id;
                    //         $Companyindustry->save();
                    //     }
                    // }
                    $Company_functionalarea =  $CompanyData['subCategory'];
                    if($Company_functionalarea != '' && $Company_functionalarea != null ){
                        foreach ($Company_functionalarea as $key => $functional_area_id) {
                            $Companyfunctionalarea = new Companyfunctionalarea();   
                            $Companyfunctionalarea->company_id              = $UpdateDetails->user_id;
                            $Companyfunctionalarea->functional_area_id      = $functional_area_id;
                            $Companyfunctionalarea->save();
                        }
                    }
                    $city_ids = $CompanyData['city'];       
                    if($city_ids != '' && $city_ids != null ){
                        foreach ($city_ids as $city_id) {
                            $insert_city = new Companycity();   
                            $insert_city->city_id       = $city_id;
                            $insert_city->company_id    = $UpdateDetails->user_id;
                            $insert_city->save();
                        }
                    }
                }    
            }  
            echo json_encode($result);
            exit;
        } catch (Throwable $e) { 
          echo json_encode(array('status'=>0,'msg'=>$e->getMessage()));             
      }
  }

  public function company_profile_image(Request $request)
  {
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
    $Companies = Companies::where('id',$company_id)->first();
    $Companies->companylogo = $request->croppedImageDataURL;
    $Companies->save();
    if($Companies){
        $result['status'] = 1;
        $result['msg'] = "Profile Image updated Successfully !";
    }
    echo json_encode($result);
    exit;
}


public function emailcheck(Request $request)
{
    $email = $request->all();
    $user_email = $email['companyemail'];
    $hid = $request->input('hid');
    $find_user = Companies::where('companyemail', '=', $user_email);  
    if ($hid > 0) {
        $find_user->where('id', '!=', $hid);
    }
    $result = $find_user->count();
    if ($result > 0) {
     echo json_encode(FALSE);
 } else {
     echo json_encode(true);
 }
}

public function companieslist(){
    return view('Admin/companies/companieslist');
}

public function companieslistdatatable(Request $request){

    if ($request->ajax()) {
        // $data = Companies::select('id','companyname','companyemail','status','created_at');
        $data = Companies::where('companyname','!=','');
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
            $action = '<input type="button" value="Delete" class="btn btn-danger " onclick="delete_companies(' . $row->id . ')">';
            $action .= '  <a href="'. route("admin-companies-edit", ["id" => $row->user_id]).'" class="btn btn-primary"  data-id = "' . $row->user_id . '">Edit</a>';       
            return $action;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
}


function deletecompaniesdata(Request $request){
    $delete_id = $request->input('id'); 
    $result['status'] = 0;
    $result['msg'] = "Oops ! company not deleted !";
    if(!empty($delete_id)){
        $del_sql = Companies::where('id',$delete_id)->delete();
        if($del_sql){
            $result['status'] = 1;
            $result['msg'] = "company Deleted Successfully";
        }
    }
    echo json_encode($result);
    exit;
}

public function editcompaniesdata($id){
    if(!empty($id)){
        $edit_sql = Companies::where('user_id',$id)->first();

        if(!empty($edit_sql)){
            // $Companyindustry = Companyindustry::where('company_id',$id)->get()->toArray();
            // $Companyindustry_id = array();
            // foreach($Companyindustry as $industry_id)
            // {
            //     $Companyindustry_id[] =  $industry_id['industry_id'];
            // }
            $Companyfunctionalarea = Companyfunctionalarea::where('company_id',$id)->get()->toArray();
            $Companyfunctionalarea_id = array();
            foreach($Companyfunctionalarea as $functionalarea_id)
            {
                $Companyfunctionalarea_id[] =  $functionalarea_id['functional_area_id'];
            }
            $Companycitys = Companycity::where('company_id',$id)->get()->toArray();
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
            $Users = Userprofile::select('id','name')->get();
            $subCategories = Functional_area::where('industry_id',isset($Companies_edit_data->industry_id) ? $Companies_edit_data->industry_id : '')->get();
            
            $package = Package::where('package_for', 0)->where('status',1)->get();    
                // $state = State::select('id','state_name')->get();
                // $city = City::select('id','city_name')->get();
            return view('Admin/companies/addcompanyform')->with(compact('Companies_edit_data','Fillcity_id','Users','Companyfunctionalarea_id','subCategories','package','industry','city','state','country'));

        }
    }
}

function GetsubCategory(Request $request){
    $industry_id = $request->input('industry');
    $result['status'] = 0;
    if($industry_id != '' && $industry_id != null){   
        $select_sql = DB::table('functional_area')->where('industry_id',$industry_id)->get();    
        $subCategorylist = '<select id="subCategory" name="subCategory" class="form-control">';
        foreach ($select_sql as $key => $value){
            $subCategorylist .='<option value="'.$value->id.'">'.$value->functional_area.'</option>';
        }
        $subCategorylist .='</select>';
        $result['status'] = 1;
        $result['list'] = $subCategorylist;
    }
    echo json_encode($result);
    exit();
}

}