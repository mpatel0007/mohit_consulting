<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\CampaignManagement;
use App\Models\Userprofile;
use App\Models\Companies;
use Illuminate\Support\Facades\Hash;
use DB;
use DataTables;
use Validator;
use Mail;


class CampaignmanagementController extends Controller
{
    public function CampaignManagement()
    {
        return view('Admin/Campaign_Management/Campaign_Management_datatable');
    }


    public function addCampaignManagement(Request $request){
        $validation = Validator::make($request->all(), [
            'name' => 'required',           
            'description'  => 'required',
            'cmfor' => 'required'
        ]);

        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }      
        $CampaignData = $request->all();
        
        $result['status'] = 0;
        $result['msg'] = "Please enter valid data";

        if($CampaignData['cmfor'] == 'candidate'){
            $candidates = Userprofile::select('id','name','email')->get()->toArray();
            foreach ($candidates as $key => $candidate) {
                $candidateEmail = $candidate['email'];
                $candidateName = $candidate['name'];
                $data = [
                    'name'              => $candidateName,
                    'subject'           => $CampaignData['subject'],
                    'email'             => $candidateEmail,
                    'description'       => $CampaignData['description'],
                  ];
                  Mail::send('Admin.Campaign_Management.Campaign_Email_template',["CampaignData"=>$data] , function($message) use ($data) {
                    $message->to($data['email'])
                    ->subject($data['subject']);
                  });
            }
        }
        if($CampaignData['cmfor'] == 'all'){
            $candidates = Userprofile::select('id','name','email')->get()->toArray();
            foreach ($candidates as $key => $candidate) {
                $candidateEmail = $candidate['email'];
                $candidateName = $candidate['name'];
                $data = [
                    'name'              => $candidateName,
                    'subject'           => $CampaignData['subject'],
                    'email'             => $candidateEmail,
                    'description'       => $CampaignData['description'],
                  ];
                  Mail::send('Admin.Campaign_Management.Campaign_Email_template',["CampaignData"=>$data] , function($message) use ($data) {
                    $message->to($data['email'])
                    ->subject($data['subject']);
                  });
            }   
            $employers = Companies::select('id','companyname','companyemail')->get()->toArray();
            foreach ($employers as $key => $employer) {
                $employerEmail = $employer['companyemail'];
                $employerName = $employer['companyname'];
                $data = [
                    'name'              => $employerName,
                    'subject'           => $CampaignData['subject'],
                    'email'             => $employerEmail,
                    'description'       => $CampaignData['description'],
                  ];
                  Mail::send('Admin.Campaign_Management.Campaign_Email_template',["CampaignData"=>$data] , function($message) use ($data) {
                    $message->to($data['email'])
                    ->subject($data['subject']);
                  });
            }
        }
        
        if($CampaignData['cmfor'] == 'employers'){
            $employers = Companies::select('id','companyname','companyemail')->get()->toArray();
            foreach ($employers as $key => $employer) {
                $employerEmail = $employer['companyemail'];
                $employerName = $employer['companyname'];
                $data = [
                    'name'              => $employerName,
                    'subject'           => $CampaignData['subject'],
                    'email'             => $employerEmail,
                    'description'       => $CampaignData['description'],
                  ];
                  Mail::send('Admin.Campaign_Management.Campaign_Email_template',["CampaignData"=>$data] , function($message) use ($data) {
                    $message->to($data['email'])
                    ->subject($data['subject']);
                  });
            }
        }

        $CampaignManagement = new CampaignManagement;
            $CampaignManagement->name         = $CampaignData['name'];
            $CampaignManagement->subject      = $CampaignData['subject'];
            $CampaignManagement->description  = $CampaignData['description'];
            $CampaignManagement->campaign_for = $CampaignData['cmfor'];
            $CampaignManagement->save();
            $insert_id = $CampaignManagement->id;
            if($insert_id > 0) {
                $result['status'] = 1;
                $result['msg'] = "Campaign create successfully";
                $result['id'] = $insert_id;
            }
        
        echo json_encode($result);
        exit;
    }


    public function CampaignManagementdatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = CampaignManagement::select('id','campaign_for','name','subject');
            return Datatables::of($data)
                    ->addIndexColumn()
               ->make(true);
        }
    }
  
}
