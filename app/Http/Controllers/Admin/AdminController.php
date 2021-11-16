<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Models\Role;
use DataTables;
use Validator;

class AdminController extends Controller
{
    public function adminlist()
    {
        $role = Role::select('id','name')->get();
        return view('Admin/admin/adminlist')->with(compact('role'));
    }

    public function insertnewadmin(Request $request)
    {
         
        $validation = Validator::make($request->all(), [
            'adminname'    => 'required',
            // 'adminemail'   => 'required',
            // 'password'    => 'required',
            'role'        => 'required',
            'is_admin'    => 'required',
        ]);
        $update_id = $request->input('hid');        
        if(empty($update_id)){
            $validation->password = 'required';
            $validation->adminemail   = 'required|email|unique:admin';
        }
        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }
        $AdminData = $request->all();
        $result['status'] = 0;
        $result['msg'] = "Please enter valid data";
        $insertdata = new Admin;
        if($update_id == '' && $update_id == null){
            $insertdata->name       = $AdminData['adminname'];
            $insertdata->email      = $AdminData['adminemail'];
            $insertdata->password   = Hash::make($AdminData['password']);
            $insertdata->is_admin   = $AdminData['is_admin'];
            $insertdata->role_id       = $AdminData['role'];
            $insertdata->status = $AdminData['status'];
            $insertdata->save();
            $insert_id = $insertdata->id;
            if($insert_id > 0) {
                $result['status'] = 1;
                $result['msg'] = "Admin created Successfully";
                $result['id'] = $insert_id;
            }
        }else{
            $UpdateDetails = Admin::where('id',$update_id)->first();
            $UpdateDetails->name           = $AdminData['adminname'];
            $UpdateDetails->email          = $AdminData['adminemail'];
            $UpdateDetails->password       = !empty($AdminData['password']) ? Hash::make($AdminData['password']) : $UpdateDetails->password;
            $UpdateDetails->is_admin       = $AdminData['is_admin'];
            $UpdateDetails->role_id        = $AdminData['role'];
            $UpdateDetails->status         = $AdminData['status'];
            $UpdateDetails->save();
            $result['status'] = 1;
            $result['msg'] = "Admin Update Successfully!";
        }
        echo json_encode($result);
        exit;
    }

    public function emailcheck(Request $request)
	{
        $email = $request->all();
       
        $user_email = $email['adminemail'];

        $hid = $request->input('hid');
    
        $find_user = Admin::where('email', '=', $user_email);  
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

    public function getallAdminList(Request $request)
    {
        if ($request->ajax()) {
            // $data = Admin::select('id','name','email','adminstatus');
             $data =  DB::table('admin')
                        ->select('admin.*','role.name as role_name')
                        ->leftjoin("role", "admin.role_id", "=", "role.id");
                        // ->where('is_admin',1);
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('status', function($row){   
                        $status = "Inactive";
                        if($row->status == 1){
                            $status = "Active";
                        }
                            return $status;
                    })
                    ->addColumn('is_admin', function($row){   
                        $is_admin = "No";
                        if($row->is_admin == 1){
                            $is_admin = "Yes";
                        }
                        return $is_admin;
                    })
                    ->addColumn('action', function($row){
                        $action = '<input type="button" value="Delete" class="btn btn-danger" onclick="delete_admin(' . $row->id . ')">';
                        $action .= '  <input type="button" value="Edit" class="btn btn-primary"  onclick="edit_admin(' . $row->id . ')">';     
                            return $action;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    function deleteadmindata(Request $request){
        $delete_id = $request->input('id');
        $result['status'] = 0;
        $result['msg'] = "Oops ! User Deleted !";

        if(!empty($delete_id)){
            $del_sql = Admin::where('id',$delete_id)->delete();
            if($del_sql){
                $result['status'] = 1;
                $result['msg'] = "User Deleted Successfully";
              }
        }
      echo json_encode($result);
      exit;
    }

    public function editadmindata(Request $request){
        $edit_id = $request->input('id');
        $responsearray = array(); 
        $responsearray['status'] = 0;
        // $data = Admin::latest()->get();
        if(!empty($edit_id)){
            $edit_sql = Admin::where('id',$edit_id)->first();
            if($edit_sql){
                $responsearray['status'] = 1;
                $responsearray['admin']=$edit_sql;
            }
        }
        echo json_encode($responsearray);
        exit;
    }

   
}

