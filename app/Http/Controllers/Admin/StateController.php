<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\State;
use DB;
use DataTables;
use Validator;



class StateController extends Controller
{
    public function index()
    {
        $data['country'] = DB::table('country')->get();
        return view('Admin/state/index')->with($data);
    }

    public function insert_state(Request $request){
        $validation = Validator::make($request->all(), [
            'country' => 'required',
            'state_name' => 'required',
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
        $result['msg'] = "Oops ! State Not Inserted";

        $hid = $request->input('hid');
        $data = $request->input();
        if($hid == ''){
        $data_insert = new State;
        $data_insert->country_id =$data['country'];
        $data_insert->state_name =$data['state_name'];
        $data_insert->status =$data['status'];
        $data_insert->save();
        $insert_id = $data_insert->id;
        if($insert_id){
        $result['status'] = 1;
        $result['msg']="State inserted Successfully";
        $result['id'] = $insert_id;
        }

        }else{
          
        $update = State::where('id', $hid)->first();
        $update->country_id =$data['country'];
        $update->state_name =$data['state_name'];
        $update->status =$data['status'];
        $update->save();
        $result['status'] = 1;
        $result['msg']="State updated Successfully";

        }
    
echo json_encode($result);
exit();

 }
    function read_state(Request $request){
        if ($request->ajax()) {

            // $data = State::select('id','country_id','state_name','status');
            $data = DB::table('state')
            ->select('state.*','country.country_name')
            ->leftjoin("country","state.country_id","=","country.id");
  
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
                   
                        $action = '<button class="btn btn-danger" onclick="delete_state(' . $row->id . ')">Delete</button>';
                        $action .= '  <button class="btn btn-primary" onclick="edit_state('.$row->id.')">Edit</button>';
    
    
       
    
                            return $action;
    
                    })
                    
    
                    ->rawColumns(['action'])
    
                    ->make(true);
    
        }
        
      
    }
    function delete_state(Request $request){
        $delete['status'] = 0;
        $delete['msg'] = "Oops ! State Not Deleted";
        $delete_id = $request->input('id');
        $del_q = State::where('id',$delete_id)->delete();
        if($del_q){
            $delete['status'] = 1;
            $delete['msg'] = "State Deleted Successfully";
        }

        echo json_encode($delete);
        exit();

    }

    function edit_state(Request $request){
        $edit['status'] = 0;
        $edit_id = $request->input('id');
        $edit_q = State::where('id',$edit_id)->first();
        if($edit_q){
            $edit['status'] = 1;
            $edit['user'] = $edit_q;

        }
        echo json_encode($edit);
        exit();

    }
}