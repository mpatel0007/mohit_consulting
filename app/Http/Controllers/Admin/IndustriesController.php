<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Industries;
use DB;
use Carbon\Carbon;
use DataTables;
use Validator;



class IndustriesController extends Controller
{
    function index(){
        return view('Admin/industries/index');
    }

    function insert_industries(Request $request){
        $validation = Validator::make($request->all(), [
            'industry_name' => 'required',
            // 'is_default' => 'required',
            // 'status' => 'required',
        ]);

        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }
        $result = array();
        $result['status'] = 0;
        $result['msg'] = "Oops ! Industry Not Inserted";
        $hid = $request->input('hid');

        $data = $request->input();
 
        if($hid == '' && $hid == null){
            $data_insert = new Industries;
            $data_insert->industry_name = $data['industry_name'];
            $data_insert->is_default = $data['is_default'];
            $data_insert->status = $data['status'];
            $data_insert->created_at = Carbon::now();
            $data_insert->save();
            $insert_id = $data_insert->id;
        if($insert_id){
            $result['status'] = 1;
            $result['msg'] = "Industry Inserted Successfully";
            $result['id'] = $insert_id;
        }
        }else{
        $update = Industries::where('id', $hid)->first();
        $update->industry_name = $data['industry_name'];
        $update->is_default = $data['is_default'];
        $update->status = $data['status'];
        $update->updated_at = Carbon::now();
        $update->save();
        $result['status'] = 1;
        $result['msg'] = "Industry updated successully";

        }
       
        echo json_encode($result);
        exit();

    }

    function read_industries(Request $request){
        if ($request->ajax()) {

            $data = Industries::select('id','industry_name','is_default','status');
       

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
                        $action = '<button class="btn btn-danger" onclick="delete_industries(' . $row->id . ')">Delete</button>';
                        $action .= '  <button class="btn btn-primary" onclick="edit_industries('.$row->id.')">Edit</button>';
    
    
       
    
                            return $action;
    
                    })
                    
    
                    ->rawColumns(['action'])
    
                    ->make(true);
    
        }
      
    }

    function delete_industries(Request $request){
        $delete['status'] = 0;
        $delete['msg'] = "Oops ! Industry Not deleted";
        $delete_id = $request->input('id');
        $del_q = Industries::where('id',$delete_id)->delete();
        if($del_q){
            $delete['status'] = 1;
            $delete['msg'] = "Industry Deleted Successfully";
        }

        echo json_encode($delete);
        exit();

    }

    function edit_industries(Request $request){
        $edit['status'] = 0;
        $edit_id = $request->input('id');
        $edit_q = Industries::where('id',$edit_id)->first();
        if($edit_q){
            $edit['status'] = 1;
            $edit['user'] = $edit_q;

        }
        echo json_encode($edit);
        exit();

    }

 }

