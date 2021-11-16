<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Models\Companies;
use App\Models\Companycity;
use App\Models\Companyindustry;
use App\Models\Companyfunctionalarea;
use Carbon\Carbon;

class CompanyProfileController extends APIController
{
    public function info(){
        if (Auth::check()) {
        $user_id = Auth::user()->id;
        $return = array();
        $return = Companies::select('companies.*','industries.industry_name','country.country_name','state.state_name')
                            ->leftJoin('industries','industries.id','companies.industry_id')
                            ->leftJoin('country','country.id','companies.country_id')
                            ->leftJoin('state','state.id','companies.state_id')
                            ->where('companies.user_id',$user_id)->first();
        if($return->ownershiptype == 1){
            $return->ownershiptype = 'Sole Proprietorship';
        }
        if($return->ownershiptype == 2){
            $return->ownershiptype = 'Public';
        }
        if($return->ownershiptype == 3){
            $return->ownershiptype = 'Private';
        }
        if($return->ownershiptype == 4){
            $return->ownershiptype = 'Government';
        }
        if($return->ownershiptype == 5){
            $return->ownershiptype = 'NGO';
        }
        $return['company_city'] = Companycity::select('city.id','city.city_name')->leftJoin('city','city.id','company_city.city_id')->where('company_city.company_id',$user_id)->get();
        $temp_company_city = array();
        if(!empty($return['company_city'])){
            
            foreach($return['company_city'] as $company_city){
                $temp_company_city[] = $company_city->id;
            }
        }
        $return['city_ids'] = $temp_company_city;
        $return['company_functionalarea'] = Companyfunctionalarea::select('functional_area.id','functional_area.functional_area')->leftJoin('functional_area','functional_area.id','Company_functional_area.functional_area_id')->where('Company_functional_area.company_id',$user_id)->get();
        $temp_company_functionalarea = array();
        if(!empty($return['company_functionalarea'])){
            
            foreach($return['company_functionalarea'] as $company_functionalarea){
                $temp_company_functionalarea[] = $company_functionalarea->id;
            }
        }
        $return['functionalarea_ids'] = $temp_company_functionalarea;
        $json['data'] = $return;
        return $this->respond($json);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
    public function update_basic(Request $request){
        $validation = Validator::make($request->all(), [
            'companyname'     => 'required',
            'companyemail'=>'required',
            'ownershiptype'=>'required',
            'companydetail'=>'required',
            'industry_id'=>'required',
            'numberofoffices'=>'required',
            'numberofemployees'=>'required',
            'establishedin'=>'required',
            // 'functional_area'=>'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
          $Companies = Companies::where('companies.user_id',Auth::user()->id)->first();
          if(!empty($Companies)){
            if($request->ownershiptype == 'Sole Proprietorship'){
                $Companies->ownershiptype = 1;
            }
            if($request->ownershiptype == 'Public'){
                $Companies->ownershiptype = 2;
            }
            if($request->ownershiptype == 'Private'){
                $Companies->ownershiptype = 3;
            }
            if($request->ownershiptype == 'Government'){
                $Companies->ownershiptype = 4;
            }
            if($request->ownershiptype == 'NGO'){
                $Companies->ownershiptype = 5;
            }
            $Companies->companyname = $request->companyname;
            $Companies->companyemail = $request->companyemail;
            $Companies->companydetail = $request->companydetail;
            $Companies->industry_id = $request->industry_id;
            $Companies->numberofoffices = $request->numberofoffices;
            $Companies->numberofemployees = $request->numberofemployees;
            $Companies->establishedin = $request->establishedin;
            $Companies->save();
            if(!empty($request->functional_area)){
                Companyfunctionalarea::where('company_id',Auth::user()->id)->delete();
                foreach($request->functional_area as $functional_area){
                    $Companyfunctionalarea = new Companyfunctionalarea();
                    $Companyfunctionalarea->company_id = Auth::user()->id;
                    $Companyfunctionalarea->functional_area_id = $functional_area;
                    $Companyfunctionalarea->created_at = Carbon::now();
                    $Companyfunctionalarea->updated_at = Carbon::now();
                    $Companyfunctionalarea->save();
                }
            }
            $return = Companies::select('companies.*','industries.industry_name','country.country_name','state.state_name')
                                ->leftJoin('industries','industries.id','companies.industry_id')
                                ->leftJoin('country','country.id','companies.country_id')
                                ->leftJoin('state','state.id','companies.state_id')
                                ->where('companies.user_id',Auth::user()->id)->first();
            if($return->ownershiptype == 1){
                $return->ownershiptype = 'Sole Proprietorship';
            }
            if($return->ownershiptype == 2){
                $return->ownershiptype = 'Public';
            }
            if($return->ownershiptype == 3){
                $return->ownershiptype = 'Private';
            }
            if($return->ownershiptype == 4){
                $return->ownershiptype = 'Government';
            }
            if($return->ownershiptype == 5){
                $return->ownershiptype = 'NGO';
            }
            $return['company_city'] = Companycity::select('city.id','city.city_name')->leftJoin('city','city.id','company_city.city_id')->where('company_city.company_id',Auth::user()->id)->get();
            $return['company_functionalarea'] = Companyfunctionalarea::select('functional_area.id','functional_area.functional_area')->leftJoin('functional_area','functional_area.id','Company_functional_area.functional_area_id')->where('Company_functional_area.company_id',Auth::user()->id)->get();
            $temp_company_city = array();
            if(!empty($return['company_city'])){
                
                foreach($return['company_city'] as $company_city){
                    $temp_company_city[] = $company_city->id;
                }
            }
            $return['city_ids'] = $temp_company_city;


            $temp_company_functionalarea = array();
            if(!empty($return['company_functionalarea'])){
                
                foreach($return['company_functionalarea'] as $company_functionalarea){
                    $temp_company_functionalarea[] = $company_functionalarea->id;
                }
            }
            $return['functionalarea_ids'] = $temp_company_functionalarea;
            $json['data'] = $return;
            $json['msg'] = "Company Profile Update Successfully.!";
            return $this->respond($json);
          }else{
            return $this->noRespondWithMessage('company not found.!');    
          }
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }

    public function update_location(Request $request){
        $validation = Validator::make($request->all(), [
            'country_id'     => 'required',
            'state_id'=>'required',
            // 'city_id'=>'required',
            
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
          $Companies = Companies::where('companies.user_id',Auth::user()->id)->first();
          if(!empty($Companies)){
           
            $Companies->country_id = $request->country_id;
            $Companies->state_id = $request->state_id;
            $Companies->save();

            if(!empty($request->city_id)){
                Companycity::where('company_id',Auth::user()->id)->delete();
                foreach($request->city_id as $city){
                    $Companycity = new Companycity();
                    $Companycity->company_id = Auth::user()->id;
                    $Companycity->city_id = $city;
                    $Companycity->created_at = Carbon::now();
                    $Companycity->updated_at = Carbon::now();
                    $Companycity->save();
                }
            }
            $return = Companies::select('companies.*','industries.industry_name','country.country_name','state.state_name')
                                ->leftJoin('industries','industries.id','companies.industry_id')
                                ->leftJoin('country','country.id','companies.country_id')
                                ->leftJoin('state','state.id','companies.state_id')
                                ->where('companies.user_id',Auth::user()->id)->first();
            if($return->ownershiptype == 1){
                $return->ownershiptype = 'Sole Proprietorship';
            }
            if($return->ownershiptype == 2){
                $return->ownershiptype = 'Public';
            }
            if($return->ownershiptype == 3){
                $return->ownershiptype = 'Private';
            }
            if($return->ownershiptype == 4){
                $return->ownershiptype = 'Government';
            }
            if($return->ownershiptype == 5){
                $return->ownershiptype = 'NGO';
            }
            $return['company_city'] = Companycity::select('city.id','city.city_name')->leftJoin('city','city.id','company_city.city_id')->where('company_city.company_id',Auth::user()->id)->get();
            $return['company_functionalarea'] = Companyfunctionalarea::select('functional_area.id','functional_area.functional_area')->leftJoin('functional_area','functional_area.id','Company_functional_area.functional_area_id')->where('Company_functional_area.company_id',Auth::user()->id)->get();
            $temp_company_city = array();
            if(!empty($return['company_city'])){
                
                foreach($return['company_city'] as $company_city){
                    $temp_company_city[] = $company_city->id;
                }
            }
            $return['city_ids'] = $temp_company_city;


            $temp_company_functionalarea = array();
            if(!empty($return['company_functionalarea'])){
                
                foreach($return['company_functionalarea'] as $company_functionalarea){
                    $temp_company_functionalarea[] = $company_functionalarea->id;
                }
            }
            $return['functionalarea_ids'] = $temp_company_functionalarea;
            $json['data'] = $return;
            $json['msg'] = "Company Profile Update Successfully.!";
            return $this->respond($json);
          }else{
            return $this->noRespondWithMessage('company not found.!');    
          }
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }

    public function update_details(Request $request){
        $validation = Validator::make($request->all(), [
            'website'     => 'required',
            'fax'=>'required',
            'phone'=>'required',
            // 'facebook'=>'required',
            // 'twitter'=>'required',
            // 'linkedin'=>'required',
            // 'google'=>'required',
            // 'pinterest'=>'required',
            
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
          $Companies = Companies::where('companies.user_id',Auth::user()->id)->first();
          if(!empty($Companies)){
           
            $Companies->website = $request->website;
            $Companies->fax = $request->fax;
            $Companies->phone = $request->phone;
            $Companies->facebook = $request->facebook;
            $Companies->twitter = $request->twitter;
            $Companies->linkedin = $request->linkedin;
            $Companies->google = $request->google;
            $Companies->pinterest = $request->pinterest;
            $Companies->save();

            
            $return = Companies::select('companies.*','industries.industry_name','country.country_name','state.state_name')
                                ->leftJoin('industries','industries.id','companies.industry_id')
                                ->leftJoin('country','country.id','companies.country_id')
                                ->leftJoin('state','state.id','companies.state_id')
                                ->where('companies.user_id',Auth::user()->id)->first();
            if($return->ownershiptype == 1){
                $return->ownershiptype = 'Sole Proprietorship';
            }
            if($return->ownershiptype == 2){
                $return->ownershiptype = 'Public';
            }
            if($return->ownershiptype == 3){
                $return->ownershiptype = 'Private';
            }
            if($return->ownershiptype == 4){
                $return->ownershiptype = 'Government';
            }
            if($return->ownershiptype == 5){
                $return->ownershiptype = 'NGO';
            }
            $return['company_city'] = Companycity::select('city.id','city.city_name')->leftJoin('city','city.id','company_city.city_id')->where('company_city.company_id',Auth::user()->id)->get();
            $return['company_functionalarea'] = Companyfunctionalarea::select('functional_area.id','functional_area.functional_area')->leftJoin('functional_area','functional_area.id','Company_functional_area.functional_area_id')->where('Company_functional_area.company_id',Auth::user()->id)->get();
            $temp_company_city = array();
            if(!empty($return['company_city'])){
                
                foreach($return['company_city'] as $company_city){
                    $temp_company_city[] = $company_city->id;
                }
            }
            $return['city_ids'] = $temp_company_city;


            $temp_company_functionalarea = array();
            if(!empty($return['company_functionalarea'])){
                
                foreach($return['company_functionalarea'] as $company_functionalarea){
                    $temp_company_functionalarea[] = $company_functionalarea->id;
                }
            }
            $return['functionalarea_ids'] = $temp_company_functionalarea;
            $json['data'] = $return;
            $json['msg'] = "Company Profile Update Successfully.!";
            return $this->respond($json);
          }else{
            return $this->noRespondWithMessage('company not found.!');    
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
            $Companies = Companies::where('user_id',Auth::user()->id)->first();
          if(!empty($Companies)){
           
            $Companies->companylogo = $request->profile_pic;
            $Companies->save();

            $return = Companies::select('companies.*','industries.industry_name','country.country_name','state.state_name')
                                ->leftJoin('industries','industries.id','companies.industry_id')
                                ->leftJoin('country','country.id','companies.country_id')
                                ->leftJoin('state','state.id','companies.state_id')
                                ->where('companies.user_id',Auth::user()->id)->first();
            if($return->ownershiptype == 1){
                $return->ownershiptype = 'Sole Proprietorship';
            }
            if($return->ownershiptype == 2){
                $return->ownershiptype = 'Public';
            }
            if($return->ownershiptype == 3){
                $return->ownershiptype = 'Private';
            }
            if($return->ownershiptype == 4){
                $return->ownershiptype = 'Government';
            }
            if($return->ownershiptype == 5){
                $return->ownershiptype = 'NGO';
            }
            $return['company_city'] = Companycity::select('city.id','city.city_name')->leftJoin('city','city.id','company_city.city_id')->where('company_city.company_id',Auth::user()->id)->get();
            $return['company_functionalarea'] = Companyfunctionalarea::select('functional_area.id','functional_area.functional_area')->leftJoin('functional_area','functional_area.id','Company_functional_area.functional_area_id')->where('Company_functional_area.company_id',Auth::user()->id)->get();
            $temp_company_city = array();
            if(!empty($return['company_city'])){
                
                foreach($return['company_city'] as $company_city){
                    $temp_company_city[] = $company_city->id;
                }
            }
            $return['city_ids'] = $temp_company_city;


            $temp_company_functionalarea = array();
            if(!empty($return['company_functionalarea'])){
                
                foreach($return['company_functionalarea'] as $company_functionalarea){
                    $temp_company_functionalarea[] = $company_functionalarea->id;
                }
            }
            $return['functionalarea_ids'] = $temp_company_functionalarea;
            $json['data'] = $return;
            $json['msg'] = "Company Profile Update Successfully.!";
            return $this->respond($json);
          }else{
            return $this->noRespondWithMessage('company not found.!');    
          }
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
}
