<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Package;
use DataTables;
use Validator;


class PackageController extends Controller
{
    //
    function index(){ 
        return view('Admin/package/index');
    }
    function insert_package(Request $request){
        $validation = Validator::make($request->all(), [
            'package_title' => 'required',
            'package_price' => 'required',
            'package_num_days' => 'required',
            //'package_num_listings' => 'required',
            'package_for' => 'required',
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
        $result['msg'] = "Oops ! Package Not Inserted";

        $hid = $request->input('hid');
        $data = $request->input();
        if($hid == ''){
            $data_insert = new Package;
            $data_insert->package_title =$data['package_title'];
            $data_insert->package_price =$data['package_price'];
            $data_insert->package_num_days =$data['package_num_days'];
            $data_insert->package_num_listings =$data['package_num_listings'];
            $data_insert->package_for =$data['package_for'];
            $data_insert->status =$data['status'];
            $data_insert->save();
            $insert_id = $data_insert->id;
            if($insert_id){
                $result['status'] = 1;
                $result['msg']="Package inserted Successfully";
                $result['id'] = $insert_id;

                /*\Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                $productData = \Stripe\Product::create ([       
                    'name' => $data['package_title'],
                    'type' => 'service'    
                ]);    

                if(!empty($productData) && isset($productData->id)) {
                    $planData = \Stripe\Plan::create ([             
                        "amount"=>$data['package_price']*100,
                        'currency' => 'usd',
                        'interval' => 'month',
                        'product' => $productData->id       
                    ]);          
                    if(!empty($planData) && isset($planData->id)) {
                        Package::where('id',$insert_id)->update(array('stripe_package_id'=>$planData->id));
                    }    
                    
                }*/     
                
            }

        }else{

            $update = Package::where('id', $hid)->first();
            $stripePlanID = $update['stripe_package_id'];
            $update->package_title =$data['package_title'];
            $update->package_price =$data['package_price'];
            $update->package_num_days =$data['package_num_days'];
            $update->package_num_listings =$data['package_num_listings'];
            $update->package_for =$data['package_for'];
            $update->status =$data['status'];
            $update->save();

            $result['status'] = 1;
            $result['msg']="Package updated Successfully";

        }

        echo json_encode($result);
        exit();
    }

    function read_package(Request $request){
        if ($request->ajax()) {

            $data = Package::select('id','package_title','package_price','package_num_days','package_num_listings','package_for','status');


            return Datatables::of($data)

            ->addIndexColumn()
            ->addColumn('status', function($row){   
                $status = "Inactive";
                if($row->status == 1){
                    $status = "Active";
                }
                return $status;
            })
            ->addColumn('package_for', function($row){   
                $package_for = "Employer";
                if($row->package_for == 1){
                    $package_for = "Candidate";
                }    
                return $package_for;
            })
            ->addColumn('action', function($row){

                $action = '<button class="btn btn-danger" onclick="delete_package(' . $row->id . ')">Delete</button>';
                /*$action .= '  <button class="btn btn-primary" onclick="edit_package('.$row->id.')">Edit</button>';*/  
                return $action;

            })

            ->rawColumns(['action'])

            ->make(true);

        }

    }

    function delete_package(Request $request){
        $delete['status']=0;
        $delete['msg']= "Oops ! Package not Deleted ";
        $d_id=$request->input('id');
        $del = Package::where('id', $d_id)->delete();

        if($del){
          $delete['status']= 1;
          $delete['msg']= "Package Deleted Successfully";


      }
      echo json_encode($delete);
      exit();

  }
  function edit_package(Request $request){
    $edit = array();
    $edit['status'] = 0;
    $e_id=$request->input('id');
    $edtq =	Package::where('id', $e_id)->first();
    
    if($edtq){
        $edit['status'] = 1;
        $edit['user']=$edtq;
    }
    echo json_encode($edit);
    exit();
}

}
