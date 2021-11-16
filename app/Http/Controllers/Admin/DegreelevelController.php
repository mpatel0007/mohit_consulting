<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\Degreelevel;
use Illuminate\Support\Facades\Hash;
use DB;
use DataTables;
use Validator;


class DegreelevelController extends Controller
{
    public function degreelevel()
    {
        return view('Admin/degreelevel/indexdegreelevel');
    }


    public function adddegreelevel(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'degreelevel' => 'required',
            // 'status' => 'required',
        ]);

        if ($validation->fails()) {
            
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();

        }
        $update_id = $request->input('hid');        
        $degreelevelData = $request->all();
        $result['status'] = 0;
        $result['msg'] = "Please enter valid data";
        $insertdata = new Degreelevel;
        if($update_id == '' && $update_id == null){
            $insertdata->degreelevel       = $degreelevelData['degreelevel'];
            $insertdata->status = $degreelevelData['status'];
            $insertdata->save();
            $insert_id = $insertdata->id;
            if($insert_id > 0) {
                $result['status'] = 1;
                $result['msg'] = "Degree Level created successfully";
                $result['id'] = $insert_id;
            }
        }else{
            $UpdateDetails = Degreelevel::where('id',$update_id)->first();
            $UpdateDetails->degreelevel           = $degreelevelData['degreelevel'];
            $UpdateDetails->status     = $degreelevelData['status'];
            $UpdateDetails->save();
            $result['status'] = 1;
            $result['msg'] = "Degree Level Updated Successfully!";
        }
        
        echo json_encode($result);
        exit;
    }


    public function degreeleveldatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Degreelevel::select('id','degreelevel','status');
            
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
                        $action = '<input type="button"  value="Delete" class="btn btn-danger " onclick="delete_degreelevel(' . $row->id . ')">';
                        $action .= '  <input type="button" value="Edit" class="btn btn-primary"  onclick="edit_degreelevel(' . $row->id . ')">';     
                        return $action;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    function deletedegreeleveldata(Request $request){
        $delete_id = $request->input('id');
        $result['status'] = 0;
        $result['msg'] = "Oops ! Degree level not Deleted !";

        if(!empty($delete_id)){
            $del_sql = Degreelevel::where('id',$delete_id)->delete();
            if($del_sql){
                $result['status'] = 1;
                $result['msg'] = "Degree level Deleted Successfully";
              }
        }
      echo json_encode($result);
      exit;
    }

    public function editdegreeleveldata(Request $request){
        $edit_id = $request->input('id');
        $responsearray = array(); 
        $responsearray['status'] = 0;
        if(!empty($edit_id)){
            $edit_sql = Degreelevel::where('id',$edit_id)->first();
            if($edit_sql){
                $responsearray['status'] = 1;
                $responsearray['degreelevel']=$edit_sql;
            }
        }
        echo json_encode($responsearray);
        exit;
    }

   
}
