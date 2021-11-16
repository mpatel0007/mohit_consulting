<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\Careerlevel;
use App\Models\Jobskill;
use Illuminate\Support\Facades\Hash;
use DB;
use DataTables;
use Validator;


class CareerlevelController extends Controller
{
    public function Careerlevel()
    {
        return view('Admin/career_level/career_level_list');
    }


    public function addCareerLevel(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'career_level' => 'required',
            // 'status' => 'required',
        ]);

        if ($validation->fails()) {
            
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();

        }
        $update_id = $request->input('hid');        
        $CareerlevelData = $request->all();
        $result['status'] = 0;
        $result['msg'] = "Please enter valid data";
        $insertdata = new Careerlevel;
        if($update_id == '' && $update_id == null){
            $insertdata->careerlevel       = $CareerlevelData['career_level'];
            $insertdata->status         = $CareerlevelData['status'];
            $insertdata->save();
            $insert_id = $insertdata->id;
            if($insert_id > 0) {
                $result['status'] = 1;
                $result['msg'] = "Career level created Successfully";
                $result['id'] = $insert_id;
            }
        }else{
            $UpdateDetails = Careerlevel::where('id',$update_id)->first();
            $UpdateDetails->careerlevel           = $CareerlevelData['career_level'];
            $UpdateDetails->status             = $CareerlevelData['status'];
            $UpdateDetails->save();
            $result['status'] = 1;
            $result['msg'] = "Career level Updated Successfully!";
        }
        
        echo json_encode($result);
        exit;
    }


    public function Careerlevel_datatable(Request $request){
        if ($request->ajax()) {
            $data = Careerlevel::select('id','careerlevel','status');
            
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
                        $action = '<input type="button"  value="Delete" class="btn btn-danger " onclick="delete_careerlevel(' . $row->id . ')">';
                        $action .= '  <input type="button" value="Edit" class="btn btn-primary"  onclick="edit_careerlevel(' . $row->id . ')">';     
                            return $action;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    function deleteCareerLevel(Request $request){
        $delete_id = $request->input('id');
        $result['status'] = 0;
        $result['msg'] = "Oops ! Job skill not deleted !";

        if(!empty($delete_id)){
            $del_sql = Careerlevel::where('id',$delete_id)->delete();
            if($del_sql){
                $result['status'] = 1;
                $result['msg'] = "Job skill Deleted Successfully";
              }
        }
      echo json_encode($result);
      exit;
    }

    public function editCareerLevel(Request $request){
        $edit_id = $request->input('id');
        $responsearray = array(); 
        $responsearray['status'] = 0;
        if(!empty($edit_id)){
            $edit_sql = Careerlevel::where('id',$edit_id)->first();
            if($edit_sql){
                $responsearray['status'] = 1;
                $responsearray['careerlevel']=$edit_sql;
            }
        }
        echo json_encode($responsearray);
        exit;
    }

    public function getSkillLevel(){
        $jobskill =  Jobskill::select('id','jobskill')->get();
        $career =  Careerlevel::select('id','careerlevel')->get();
        $skill = array();
        $career_level = array();
        if (!empty($jobskill)) {
            foreach ($jobskill as $explodeKey => $explodeValue) {
                $skill[$explodeValue->id] = $explodeValue->jobskill;
            }
        }
        if (!empty($career)) {
            foreach ($career as $explodeKey => $careerValue) {
                $career_level[$careerValue->id] = $careerValue->careerlevel;
            }
        }
        $data['skills'] = $skill;
        $data['career'] = $career_level;
        echo json_encode($data);
        exit;
    }

   
}
