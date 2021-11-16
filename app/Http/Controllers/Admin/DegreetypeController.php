<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\Degreetype;
use App\Models\Degreelevel;
use Illuminate\Support\Facades\Hash;
use DB;
use DataTables;
use Validator;


class DegreetypeController extends Controller
{
    public function degreetype()
    {
        $data['degreelevel'] = Degreelevel::select('id','degreelevel')->get();
        return view('Admin/degreetype/indexdegreetype')->with($data);
    }

    public function adddegreetype(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'degreelevel' => 'required',
            'degreetype' => 'required',
            // 'status' => 'required',
        ]);

        if ($validation->fails()) {
            
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();

        }
        $update_id = $request->input('hid');        
        $degreeTypeData = $request->all();
        $result['status'] = 0;
        $result['msg'] = "Please enter valid data";
        $insertdata = new Degreetype;
        if($update_id == '' && $update_id == null){
            $insertdata->degreelevel_id      = $degreeTypeData['degreelevel'];
            $insertdata->degreetype          = $degreeTypeData['degreetype'];
            $insertdata->status              = $degreeTypeData['status'];
            $insertdata->save();
            $insert_id = $insertdata->id;
            if($insert_id > 0) {
                $result['status'] = 1;
                $result['msg'] = "Degree Type created successfully";
                $result['id'] = $insert_id;
            }
        }else{
            $UpdateDetails = Degreetype::where('id',$update_id)->first();
            $UpdateDetails->degreelevel_id       = $degreeTypeData['degreelevel'];
            $UpdateDetails->degreetype           = $degreeTypeData['degreetype'];
            $UpdateDetails->status               = $degreeTypeData['status'];
            $UpdateDetails->save();
            $result['status'] = 1;
            $result['msg'] = "Degree Type Updated Successfully!";
        }
        echo json_encode($result);
        exit;
    }

    public function degreetypedatatable(Request $request)
    {
        if ($request->ajax()) {
            // $data = Degreetype::select('id','degreelevel_id','degreetype','status');
                $data =  DB::table('degreetype')
                        ->select('degreetype.*','degreelevel.degreelevel as degreelevel')
                        ->leftjoin("degreelevel", "degreetype.degreelevel_id", "=", "degreelevel.id");
                    
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
                        $action = '<input type="button"  value="Delete" class="btn btn-danger " onclick="delete_degreetype(' . $row->id . ')">';
                        $action .= '  <input type="button" value="Edit" class="btn btn-primary"  onclick="edit_degreetype(' . $row->id . ')">';     
                        return $action;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    function deletedegreetypedata(Request $request){
        $delete_id = $request->input('id');
        $result['status'] = 0;
        $result['msg'] = "Oops ! Degree type not Deleted !";

        if(!empty($delete_id)){
            $del_sql = Degreetype::where('id',$delete_id)->delete();
            if($del_sql){
                $result['status'] = 1;
                $result['msg'] = "Degree type Deleted Successfully";
              }
        }
      echo json_encode($result);
      exit;
    }

    public function editdegreetypedata(Request $request){
        $edit_id = $request->input('id');
        $responsearray = array(); 
        $responsearray['status'] = 0;
        if(!empty($edit_id)){
            $edit_sql = Degreetype::where('id',$edit_id)->first();
            if($edit_sql){
                $responsearray['status'] = 1;
                $responsearray['degreetype']=$edit_sql;
            }
        }
        echo json_encode($responsearray);
        exit;
    }



}