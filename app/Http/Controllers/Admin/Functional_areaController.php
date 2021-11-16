<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Functional_area;
use App\Models\Industries;
use DataTables;
use Validator;

class Functional_areaController extends Controller
{
        /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Http\Response

     */
    
    function index(){
        $Categories = Industries::select()->get()->toArray();
        return view('Admin/functional_area/index')->with(compact('Categories'));
    }
        /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Http\Response

     */

    function insert_functional_area(Request $request){

        $validation = Validator::make($request->all(), [
            'functional_area' => 'required',
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
        $result['msg'] = "Oops ! Category Not Inserted";

        $hid = $request->input('hid');
        $data = $request->input();
        if($hid == ''){
        $data_insert = new Functional_area;
        $data_insert->industry_id=$data['category'];
        $data_insert->functional_area =$data['functional_area'];
        $data_insert->status =$data['status'];
        $data_insert->save();
        $insert_id = $data_insert->id;
        if($insert_id){
        $result['status'] = 1;
        $result['msg']="Category inserted Successfully";
        $result['id'] = $insert_id;
        }

        }else{
          
        $update = Functional_area::where('id', $hid)->first();
        $update->industry_id = $data['category'];
        $update->functional_area = $data['functional_area'];
        $update->status = $data['status'];
        $update->save();
        $result['status'] = 1;
        $result['msg']="Category updated Successfully";

        }

    
echo json_encode($result);
exit();
}

function read_functional_area(Request $request){
    if ($request->ajax()) {

        $data = Functional_area::select('id','functional_area','status');
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
                    $action = '<button class="btn btn-danger" onclick="delete_functional_area(' . $row->id . ')">Delete</button>';
                    $action .= '  <button class="btn btn-primary" onclick="edit_functional_area('.$row->id.')">Edit</button>';
                        return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

}

function delete_functional_area(Request $request){
    $delete['status']=0;
	$delete['msg']= "Oops ! Category not deleted ";
	$d_id=$request->input('id');
	$del = Functional_area::where('id', $d_id)->delete();
  
	if($del){
		$delete['status']= 1;
		$delete['msg']= "Category Deleted Successfully";
	}
echo json_encode($delete);
exit();

}
function edit_functional_area(Request $request){
    $edit = array();
    $edit['status'] = 0;
    $e_id=$request->input('id');
    $edtq =	Functional_area::where('id', $e_id)->first();
    
    if($edtq){
            $edit['status'] = 1;
            $edit['user']=$edtq;
     }
     echo json_encode($edit);
     exit();
    }

}