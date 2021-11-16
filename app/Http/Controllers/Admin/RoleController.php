<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Role;
use DataTables;
use Validator;


class RoleController extends Controller
{
    //
    function index(){
        return view('Admin/role/index');
    }

    

    function insertrole(Request $request){
        $validation = Validator::make($request->all(), [
            'name' => 'required',
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
        $result['msg'] = "Oops ! Role Not Inserted";

        $hid = $request->input('hid');
        $data = $request->input();

        if($hid == ''){
        $data_insert = new Role;
        $data_insert->name =$data['name'];
        $data_insert->status =$data['status'];
        $data_insert->save();
        $insert_id = $data_insert->id;
        if($insert_id){
        $result['status'] = 1;
        $result['msg']="Role inserted Successfully";
        $result['id'] = $insert_id;
        }

        }else{
          
        $update = Role::where('id', $hid)->first();
        $update->name =$data['name'];
        $update->status =$data['status'];
        $update->save();
        $result['status'] = 1;
        $result['msg']="Role updated Successfully";

        }
    
echo json_encode($result);
exit();
}

function read_data(Request $request){
    if ($request->ajax()) {

        $data = Role::select('id','name','status');
     

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

                    $action = '<button class="btn btn-danger" onclick="delete_role(' . $row->id . ')">Delete</button>';
                    $action .= '  <button class="btn btn-primary" onclick="edit_role('.$row->id.')">Edit</button>';

//                       $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

   

                        return $action;

                })

                ->rawColumns(['action'])

                ->make(true);

    }

    
}

function delete_role(Request $request){
    $delete['status']=0;
	$delete['msg']= "Oops ! Role not Deleted ";
	$d_id=$request->input('id');
	$del = Role::where('id', $d_id)->delete();
  
	if($del){
		$delete['status']= 1;
		$delete['msg']= "Role Deleted Successfully";


	}
echo json_encode($delete);
exit();

}
function edit_role(Request $request){
    $edit = array();
    $edit['status'] = 0;
    $e_id=$request->input('id');
    $edtq =	Role::where('id', $e_id)->first();
    
    if($edtq){
            $edit['status'] = 1;
            $edit['user']=$edtq;
     }
     echo json_encode($edit);
     exit();
    }

}