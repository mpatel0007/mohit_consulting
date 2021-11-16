<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\Jobskill;
use Illuminate\Support\Facades\Hash;
use DB;
use DataTables;
use Validator;


class JobskillController extends Controller
{
    public function jobskill()
    {
        return view('Admin/jobskill/indexjobskill');
    }


    public function addjobskill(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'jobskill' => 'required',
            // 'status' => 'required',
        ]);

        if ($validation->fails()) {
            
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();

        }
        $update_id = $request->input('hid');        
        $JobskillData = $request->all();
        $result['status'] = 0;
        $result['msg'] = "Please enter valid data";
        $insertdata = new Jobskill;
        if($update_id == '' && $update_id == null){
            $insertdata->jobskill       = $JobskillData['jobskill'];
            $insertdata->status = $JobskillData['status'];
            $insertdata->save();
            $insert_id = $insertdata->id;
            if($insert_id > 0) {
                $result['status'] = 1;
                $result['msg'] = "Job skill created Successfully";
                $result['id'] = $insert_id;
            }
        }else{
            $UpdateDetails = Jobskill::where('id',$update_id)->first();
            $UpdateDetails->jobskill           = $JobskillData['jobskill'];
            $UpdateDetails->status     = $JobskillData['status'];
            $UpdateDetails->save();
            $result['status'] = 1;
            $result['msg'] = "Job skill Updated Successfully!";
        }
        
        echo json_encode($result);
        exit;
    }


    public function jobskilldatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Jobskill::select('id','jobskill','status');
            
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
                        $action = '<input type="button"  value="Delete" class="btn btn-danger " onclick="delete_jobskill(' . $row->id . ')">';
                        $action .= '  <input type="button" value="Edit" class="btn btn-primary"  onclick="edit_jobskill(' . $row->id . ')">';     
                            return $action;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    function deletejobskilldata(Request $request){
        $delete_id = $request->input('id');
        $result['status'] = 0;
        $result['msg'] = "Oops ! Job skill not deleted !";

        if(!empty($delete_id)){
            $del_sql = Jobskill::where('id',$delete_id)->delete();
            if($del_sql){
                $result['status'] = 1;
                $result['msg'] = "Job skill Deleted Successfully";
              }
        }
      echo json_encode($result);
      exit;
    }

    public function editjobskilldata(Request $request){
        $edit_id = $request->input('id');
        $responsearray = array(); 
        $responsearray['status'] = 0;
        if(!empty($edit_id)){
            $edit_sql = Jobskill::where('id',$edit_id)->first();
            if($edit_sql){
                $responsearray['status'] = 1;
                $responsearray['jobskill']=$edit_sql;
            }
        }
        echo json_encode($responsearray);
        exit;
    }

   
}
