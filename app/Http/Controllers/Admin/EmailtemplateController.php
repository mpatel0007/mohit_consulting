<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Emailtemplate;
use DB;
use DataTables;
use Validator;

class EmailtemplateController extends Controller
{
    public function emailtemplate()
    {
        return view('Admin/email_template/email_template_datatable');
    }


    public function add_emailtemplate(Request $request){
        $validation = Validator::make($request->all(), [
            'title' => 'required',           
            'description'  => 'required',
            'subject' => 'required'
        ]);

        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit(); 
        }      
        $EmailtemplateData = $request->all();
        $update_id = $request->input('hid');        
        $result['status'] = 0;
        $result['msg'] = "Please enter valid data";     
        $Emailtemplate = new Emailtemplate;
        if($update_id == '' && $update_id == null){
            $Emailtemplate->title       = $EmailtemplateData['title'];
            $Emailtemplate->subject      = $EmailtemplateData['subject'];
            $Emailtemplate->description   = $EmailtemplateData['description'];
            $Emailtemplate->save();
            $insert_id = $Emailtemplate->id;
            if($insert_id > 0) {
                $result['status'] = 1;
                $result['msg'] = "Email Template created Successfully";
                $result['id'] = $insert_id;
            }
        }else{
            $UpdateDetails = Emailtemplate::where('id',$update_id)->first();
            $UpdateDetails->title           = $EmailtemplateData['title'];
            $UpdateDetails->subject           = $EmailtemplateData['subject'];
            $UpdateDetails->description       = $EmailtemplateData['description'];
            $UpdateDetails->save();
            $result['status'] = 1;
            $result['msg'] = "Email Template Update Successfully!";
        }
        echo json_encode($result);
        exit;
    }

    public function emailtemplate_datatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Emailtemplate::select('id','title','subject','description');
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $action = '  <input type="button" value="Edit" class="btn btn-primary"  onclick="edit_emailtemplate(' . $row->id . ')">';     
                        return $action;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }


    public function edit_emailtemplate(Request $request){
        $edit_id = $request->input('id');
        $responsearray = array(); 
        $responsearray['status'] = 0;
        if(!empty($edit_id)){
            $edit_sql = Emailtemplate::where('id',$edit_id)->first();
            if($edit_sql){
                $responsearray['status'] = 1;
                $responsearray['emailtemplate']=$edit_sql;
            }
        }
        echo json_encode($responsearray);
        exit;
    }
  
}
