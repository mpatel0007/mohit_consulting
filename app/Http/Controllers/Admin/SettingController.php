<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Setting;
use DataTables;
use Validator;
use Image;

class SettingController extends Controller
{
    //
    function index(){
        $setting_data['setting_data'] = DB::table('setting')->first();
        return view('Admin/setting/index')->with($setting_data);
    }
    function save_settings(Request $request){
        $validation = Validator::make($request->all(), [
            //'headerlogo'           => 'required',
            //'footerlogo'           => 'required',
            'infoaddress'          => 'required',
            'infoemail'            => 'required',
            'inquiryemail'         => 'required',
            'infocontactnumber'    => 'required',
            'footerdiscription'    => 'required',
            'facebook'             => 'required',
            'twitter'              => 'required',
            'linkedin'             => 'required',
            // 'google'               => 'required',
            'copyright'            => 'required',

        ]);
        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }

        $settingData = $request->all();
        $headerlogo = $request->file('headerlogo');
        $footerlogo = $request->file('footerlogo');

        $headerlogo_name = '';
        $footerlogo_name = '';
        if(!empty($headerlogo)){
            $headerlogo_name = 'headerlogo'.'.'.$headerlogo->getClientOriginalExtension();        
            $destinationPath = public_path('assets/admin/settingimage/');
            $headerlogo_resize = Image::make($headerlogo->getRealPath());              
            $headerlogo_resize->resize(300,200);
            if(!empty($headerlogo_name)){
                $headerlogo_resize->save($destinationPath . $headerlogo_name,80);
            }
        }
        if(!empty($footerlogo)){
            $footerlogo_name = 'footerlogo'.'.'.$footerlogo->getClientOriginalExtension();        
            $destinationPath = public_path('assets/admin/settingimage/');
            $footerlogo_resize = Image::make($footerlogo->getRealPath());              
            $footerlogo_resize->resize(300,200);
            if(!empty($footerlogo_name)){
                $footerlogo_resize->save($destinationPath . $footerlogo_name,80);
            }
        }
        
        
        $data['status'] = 0;
        $data['msg'] = "Oops ! something went Wrong !..";
        $updatesetting = Setting::all()->toArray();
        $isCreate = 1;

        if(empty($updatesetting)) {
            $updatesetting = new Setting;
        } else {
            $isCreate = 0;
            $updatesetting = Setting::find($updatesetting[0]['id'])->first();
        } 

        if($headerlogo_name !='') {
            $updatesetting->headerlogo =$headerlogo_name;    
        }
        if($footerlogo_name !='') {
            $updatesetting->footerlogo =$footerlogo_name;    
        }
        $updatesetting->infoaddress = $settingData['infoaddress'];
        $updatesetting->infoemail = $settingData['infoemail'];
        $updatesetting->inquiryemail = $settingData['inquiryemail'];
        $updatesetting->infocontactnumber =$settingData['infocontactnumber'];
        $updatesetting->footerdiscription = $settingData['footerdiscription'];
        $updatesetting->facebook = $settingData['facebook'];
        $updatesetting->twitter =$settingData['twitter'];
        $updatesetting->linkedin = $settingData['linkedin'];
        $updatesetting->google = $settingData['iframe'];
        $updatesetting->copyrightcontent = $settingData['copyright'];
        if($isCreate == 1) {
            $updatesetting->save();
        } else {
            $updatesetting->update();    
        }
        $data['status'] = 1;
        $data['msg'] = "Settings updated successfully";
        
        echo json_encode($data);
        exit();

    }

}