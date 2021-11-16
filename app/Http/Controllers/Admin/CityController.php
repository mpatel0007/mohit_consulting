<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\City;
use DB;
use DataTables;
use Validator;



class CityController extends Controller
{
    public function index()
    {
        $data['country'] = DB::table('country')->get();
        return view('Admin/city/index')->with($data);
    }
    function selectstate(Request $request){
		$select = $request->input('country');
		$select_state_id = $request->input('state');

		$result['status'] = 0;
		$select_sql = DB::table('state')->where('country_id',$select)->get();
		$statelist = '<select id="state" name="state" class="form-control">';
		foreach ($select_sql as $key => $value){
            if($value->id == $select_state_id){
			$statelist .='<option selected value="'.$value->id.'">'.$value->state_name.'</option>';
            }else{
			$statelist .='<option  value="'.$value->id.'">'.$value->state_name.'</option>';
            }
		}
		$statelist .='</select>';
		$result['status'] = 1;
		$result['list'] = $statelist;
		echo json_encode($result);
		exit();
	}

    function selectcity(Request $request){
		$select = $request->input('state');
		$result['status'] = 0;
		$select_sql = DB::table('city')->where('state_id',$select)->get();
		$citylist = '<select id="city" name="city" class="form-control">';
		foreach ($select_sql as $key => $value){
			$citylist .='<option value="'.$value->id.'">'.$value->city_name.'</option>';
		}
		$citylist .='</select>';
		$result['status'] = 1;
		$result['list'] = $citylist;
		echo json_encode($result);
		exit();
	}
    public function insert_city(Request $request){
        $validation = Validator::make($request->all(), [
            'country' => 'required',
            'state' => 'required',
            'city_name' => 'required',
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
        $result['msg'] = "Oops ! City Not Inserted";

        $hid = $request->input('hid');
        $data = $request->input();
        if($hid == ''){
        $data_insert = new City;
        $data_insert->state_id =$data['state'];
        $data_insert->city_name =$data['city_name'];
        $data_insert->status =$data['status'];
        $data_insert->save();
        $insert_id = $data_insert->id;
        if($insert_id){
        $result['status'] = 1;
        $result['msg']=" City inserted successfully";
        $result['id'] = $insert_id;
        }

        }else{
          
        $update = City::where('id', $hid)->first();
        $update->state_id =$data['state'];
        $update->city_name =$data['city_name'];
        $update->status =$data['status'];
        $update->save();
        $result['status'] = 1;
        $result['msg']="City updated successfully";

        }
    
echo json_encode($result);
exit();

 }
    function read_city(Request $request){
        if ($request->ajax()) {
            
            
            $data = DB::table('city')
                    ->select('city.*','state.state_name')
                    ->leftjoin('state','city.state_id','=','state.id');

            // City::select('id','state_id','city_name','status');
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
                   
                        $action = '<button class="btn btn-danger" onclick="delete_city(' . $row->id . ')">Delete</button>';
                        $action .= '  <button class="btn btn-primary" onclick="edit_city('.$row->id.')">Edit</button>';
                            return $action;
    
                    })
                    
                    ->rawColumns(['action'])
    
                    ->make(true);
    
        }
        
      
    }
    function delete_city(Request $request){
        $delete['status'] = 0;
        $delete['msg'] = "Oops ! City Not Deleted";
        $delete_id = $request->input('id');
        $del_q = City::where('id',$delete_id)->delete();
        if($del_q){
            $delete['status'] = 1;
            $delete['msg'] = "City Deleted Successfully";
        }

        echo json_encode($delete);
        exit();

    }

    function edit_city(Request $request){
        $edit['status'] = 0;
        $edit_id = $request->input('id');
        $edit_city = DB::table('city')
		->select('city.*','state.state_name as state_name','country.country_name as country_name' ,'country.id as country_id')
		->leftjoin("state","state.id" ,"=", "city.state_id")
    	->leftjoin("country", "country.id", "=", "state.country_id")
    	->where('city.id',$edit_id)->get();
	if($edit_city){
        // $edit_q = City::where('id',$edit_id)->first();
        // if($edit_q){
            $edit['status'] = 1;
            $edit['user'] = $edit_city[0];

        }
        echo json_encode($edit);
        exit();

    }
}