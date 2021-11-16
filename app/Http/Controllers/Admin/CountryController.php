<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\Country;
use DB;
use DataTables;
use Validator;



class CountryController extends Controller
{
    public function index()
    {
        return view('Admin/country/index');
    }

    public function insert_country(Request $request){

        $validation = Validator::make($request->all(), [
            'country_name' => 'required',
            'sort_name' => 'required',
            // 'phone_code' => 'required',
            'currency' => 'required',
            // 'code' => 'required',
            // 'symbol' => 'required',
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
        $result['msg'] = "Oops ! Country Not Inserted";

        $hid = $request->input('hid');
        $data = $request->all();
        if($hid == ''){
        $data_insert = new Country;
        $data_insert->country_name = $data['country_name'];
        $data_insert->sort_name =$data['sort_name'];
        $data_insert->phone_code =$data['phone_code'];
        $data_insert->currency =$data['currency'];
        $data_insert->code =$data['code'];
        $data_insert->symbol =$data['symbol'];
        $data_insert->status =$data['status'];
        $data_insert->save();
        $insert_id = $data_insert->id;
        if($insert_id){
        $result['status'] = 1;
        $result['msg']="Country inserted Successfully";
        $result['id'] = $insert_id;
        }

        }else{
          
        $update = Country::where('id', $hid)->first();
        $update->country_name =$data['country_name'];
        $update->sort_name =$data['sort_name'];
        $update->phone_code =$data['phone_code'];
        $update->currency =$data['currency'];
        $update->code =$data['code'];
        $update->symbol =$data['symbol'];
        $update->status =$data['status'];
        $update->save();
        $result['status'] = 1;
        $result['msg']="Country updated Successfully";

        }
    
echo json_encode($result);
exit();

    }
    function read_country(Request $request){
        if ($request->ajax()) {

            $data = Country::select('id','country_name','sort_name','currency','status');
  
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
                   
                        $action = '<button class="btn btn-danger" onclick="delete_country(' . $row->id . ')">Delete</button>';
                        $action .= '  <button class="btn btn-primary" onclick="edit_country('.$row->id.')">Edit</button>';
    
    
       
    
                            return $action;
    
                    })
                    
    
                    ->rawColumns(['action'])
    
                    ->make(true);
    
        }
        
      
    }
    function delete_country(Request $request){
        $delete['status'] = 0;
        $delete['msg'] = "Oops ! Country Not Deleted";
        $delete_id = $request->input('id');
        $del_q = Country::where('id',$delete_id)->delete();
        if($del_q){
            $delete['status'] = 1;
            $delete['msg'] = "Country Deleted Successfully";
        }

        echo json_encode($delete);
        exit();

    }

    function edit_country(Request $request){
        $edit['status'] = 0;
        $edit_id = $request->input('id');
        $edit_q = Country::where('id',$edit_id)->first();
        if($edit_q){
            $edit['status'] = 1;
            $edit['user'] = $edit_q;

        }
        echo json_encode($edit);
        exit();

    }
}