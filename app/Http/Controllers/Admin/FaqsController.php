<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\Faqs;
use Illuminate\Support\Facades\Hash;
use DB;
use DataTables;
use Validator;

class FaqsController extends Controller
{
    public function index()
    {
        return view('Admin/Faqs/index');
    }

    public function insert_faqs(Request $request){
        $validation = Validator::make($request->all(), [
            'questioneditor' => 'required',
            'answereditor' => 'required',
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
        $result['msg'] = "Oops ! Faqs Not Inserted";

        $hid = $request->input('hid');
        $data = $request->all();
        if($hid == ''){
        $data_insert = new Faqs;
        $data_insert->questioneditor =$data['questioneditor'];
        $data_insert->answereditor =$data['answereditor'];
        $data_insert->status =$data['status'];
        $data_insert->save();
        $insert_id = $data_insert->id;
        if($insert_id){
        $result['status'] = 1;
        $result['msg']="Faqs inserted Successfully";
        $result['id'] = $insert_id;
        }

        }else{
          
        $update = Faqs::where('id', $hid)->first();
        $update->questioneditor =$data['questioneditor'];
        $update->answereditor =$data['answereditor'];
        $update->status =$data['status'];
        $update->save();
        $result['status'] = 1;
        $result['msg']="Faqs updated Successfully";

        }
    
echo json_encode($result);
exit();

    }
    function read_faqs(Request $request){
        if ($request->ajax()) {

            $data = Faqs::select('id','questioneditor','answereditor','status');
  
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
                   
                        $action = '<button class="btn btn-danger" onclick="delete_faqs(' . $row->id . ')">Delete</button>';
                        $action .= '  <button class="btn btn-primary" onclick="edit_faqs('.$row->id.')">Edit</button>';
    
    
       
    
                            return $action;
    
                    })
                    
    
                    ->rawColumns(['action'])
    
                    ->make(true);
    
        }
        
      
    }
    function delete_faqs(Request $request){
        $delete['status'] = 0;
        $delete['msg'] = "Oops ! Faqs Not deleted";
        $delete_id = $request->input('id');
        $del_q = Faqs::where('id',$delete_id)->delete();
        if($del_q){
            $delete['status'] = 1;
            $delete['msg'] = "Faqs Deleted Successfully";
        }

        echo json_encode($delete);
        exit();

    }

    function edit_faqs(Request $request){
        $edit['status'] = 0;
        $edit_id = $request->input('id');
        $edit_q = Faqs::where('id',$edit_id)->first();
        if($edit_q){
            $edit['status'] = 1;
            $edit['user'] = $edit_q;

        }
        echo json_encode($edit);
        exit();

    }
}