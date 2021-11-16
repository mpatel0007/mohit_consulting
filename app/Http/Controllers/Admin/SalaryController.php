<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Salary;
use DB;
use DataTables;
use Validator;


class SalaryController extends Controller
{
    public function salary()
    {
        return view('Admin/Salary/salary_datatable');
    }


    public function addsalary(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'salary' => 'required',
        ]);

        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }
        $update_id = $request->input('hid');        
        $salaryData = $request->all();
        $result['status'] = 0;
        $result['msg'] = "Please enter valid data";
        $insertdata = new Salary;
        if($update_id == '' && $update_id == null){
            $insertdata->salary       = $salaryData['salary'];
            $insertdata->status = $salaryData['status'];
            $insertdata->save();
            $insert_id = $insertdata->id;
            if($insert_id > 0) {
                $result['status'] = 1;
                $result['msg'] = "Salary created successfully";
                $result['id'] = $insert_id;
            }
        }else{
            $UpdateDetails = Salary::where('id',$update_id)->first();
            $UpdateDetails->salary           = $salaryData['salary'];
            $UpdateDetails->status     = $salaryData['status'];
            $UpdateDetails->save();
            $result['status'] = 1;
            $result['msg'] = "Salary Updated Successfully!";
        }
        
        echo json_encode($result);
        exit;
    }

    public function salarydatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Salary::select('id','salary','status');
            
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
                        $action = '<input type="button"  value="Delete" class="btn btn-danger " onclick="delete_salary(' . $row->id . ')">';
                        $action .= '  <input type="button" value="Edit" class="btn btn-primary"  onclick="edit_salary(' . $row->id . ')">';     
                        return $action;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    function deletesalarydata(Request $request){
        $delete_id = $request->input('id');
        $result['status'] = 0;
        $result['msg'] = "Oops ! Salary not Deleted !";

        if(!empty($delete_id)){
            $del_sql = Salary::where('id',$delete_id)->delete();
            if($del_sql){
                $result['status'] = 1;
                $result['msg'] = "Salary Deleted Successfully";
              }
        }
      echo json_encode($result);
      exit;
    }

    public function editsalarydata(Request $request){
        $edit_id = $request->input('id');
        $responsearray = array(); 
        $responsearray['status'] = 0;
        if(!empty($edit_id)){
            $edit_sql = Salary::where('id',$edit_id)->first();
            if($edit_sql){
                $responsearray['status'] = 1;
                $responsearray['salary']=$edit_sql;
            }
        }
        echo json_encode($responsearray);
        exit;
    }

   
}
