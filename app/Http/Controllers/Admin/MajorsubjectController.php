<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Major_subject;
use DataTables;
use Validator;


class MajorsubjectController extends Controller
{
    //
    function index(){
        return view('Admin/major_subject/index');
    }
    function insert_major_subject(Request $request){
        $validation = Validator::make($request->all(), [
            'major_subject' => 'required',
            // 'status' => 'required',
        ]);

        if ($validation->fails()) {
            
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();

        }
        $result= array();
        $result['status'] = 0;
        $result['msg'] = "Oops ! Major Subject Not Inserted";

        $hid = $request->input('hid');
        $data = $request->input();
        if($hid == ''){
        $data_insert = new Major_subject;
        $data_insert->major_subject =$data['major_subject'];
        $data_insert->status =$data['status'];
        $data_insert->save();
        $insert_id = $data_insert->id;
        if($insert_id){
        $result['status'] = 1;
        $result['msg']="Major Subject inserted Successfully";
        $result['id'] = $insert_id;
        }

        }else{
          
        $update = Major_subject::where('id', $hid)->first();
        $update->major_subject =$data['major_subject'];
        $update->status =$data['status'];
        $update->save();
        $result['status'] = 1;
        $result['msg']="Major Subject updated Successfully";

        }
    
echo json_encode($result);
exit();
}

function read_major_subject(Request $request){
    if ($request->ajax()) {

        $data = Major_subject::select('id','major_subject','status');
     

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

                    $action = '<button class="btn btn-danger" onclick="delete_major_subject(' . $row->id . ')">Delete</button>';
                    $action .= '  <button class="btn btn-primary" onclick="edit_major_subject('.$row->id.')">Edit</button>';


   

                        return $action;

                })

                ->rawColumns(['action'])

                ->make(true);

    }
    
}

function delete_major_subject(Request $request){
    $delete['status']=0;
	$delete['msg']= "Oops ! Major Subject not Deleted ";
	$d_id=$request->input('id');
	$del = Major_subject::where('id', $d_id)->delete();
  
	if($del){
		$delete['status']= 1;
		$delete['msg']= "Major Subject Deleted Successfully";


	}
echo json_encode($delete);
exit();

}
function edit_major_subject(Request $request){
    $edit = array();
    $edit['status'] = 0;
    $e_id=$request->input('id');
    $edtq =	Major_subject::where('id', $e_id)->first();
    
    if($edtq){
            $edit['status'] = 1;
            $edit['user']=$edtq;
     }
     echo json_encode($edit);
     exit();
    }

}
