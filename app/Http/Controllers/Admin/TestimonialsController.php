<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use DB;
use DataTables;
use Validator;




class TestimonialsController extends Controller
{
    //
    function index(){
        return view('Admin/testimonials/index');
    }

    function insert_testimonial(Request $request){
        $validation = Validator::make($request->all(), [
            'testimonial_by' => 'required',
            'testimonial' => 'required',
            'company_and_designation' => 'required',
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
        $result['msg'] = "Testimonial Not Inserted";
        $hid = $request->input('hid');

        $data = $request->input();
 
        if($hid == '' && $hid == null){
            $data_insert = new Testimonial;
            $data_insert->testimonial_by = $data['testimonial_by'];
            $data_insert->testimonial = $data['testimonial'];
            $data_insert->company_and_designation = $data['company_and_designation'];
            $data_insert->is_default = $data['is_default'];
            $data_insert->status = $data['status'];
            $data_insert->save();
            $insert_id = $data_insert->id;
        if($insert_id){
        $result['status'] = 1;
        $result['msg'] = "Testimonial Inserted Successfully";
        $result['id'] = $insert_id;
        }
        }else{
        $update = Testimonial::where('id', $hid)->first();
        $update->testimonial_by = $data['testimonial_by'];
        $update->testimonial = $data['testimonial'];
        $update->company_and_designation = $data['company_and_designation'];
        $update->is_default = $data['is_default'];
        $update->status = $data['status'];
        $update->save();
        $result['status'] = 1;
        $result['msg'] = "Testimonial updated Successfully";

        }
       
        echo json_encode($result);
        exit();

    }

    function read_testimonial(Request $request){
        if ($request->ajax()) {

            $data = Testimonial::select('id','testimonial_by','testimonial','company_and_designation','is_default','status');

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
                        $action = '<button class="btn btn-danger" onclick="delete_testimonial(' . $row->id . ')">Delete</button>';
                        $action .= '  <button class="btn btn-primary" onclick="edit_testimonial('.$row->id.')">Edit</button>';
    
    
       
    
                            return $action;
    
                    })
                    
    
                    ->rawColumns(['action'])
    
                    ->make(true);
    
        }
      
    }

    function delete_testimonial(Request $request){
        $delete['status'] = 0;
        $delete['msg'] = "Oops ! Testimonial Not Deleted";
        $delete_id = $request->input('id');
        $del_q = Testimonial::where('id',$delete_id)->delete();
        if($del_q){
            $delete['status'] = 1;
            $delete['msg'] = "Testimonial Deleted Successfully";
        }

        echo json_encode($delete);
        exit();

    }

    function edit_testimonial(Request $request){
        $edit['status'] = 0;
        $edit_id = $request->input('id');
        $edit_q = Testimonial::where('id',$edit_id)->first();
        if($edit_q){
            $edit['status'] = 1;
            $edit['user'] = $edit_q;

        }
        echo json_encode($edit);
        exit();

    }

 }

