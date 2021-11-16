<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\Contact;
use DB;
use DataTables;
use Validator;



class ContactController extends Controller
{
    public function index()
    {

        return view('Admin/contact/index');
    }

function contactus_list(Request $request){
    if ($request->ajax()) {

        $data = Contact::select('id','name','email','msg_subject','message');

        return Datatables::of($data)

                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = '<button class="btn btn-danger" onclick="delete_contact(' . $row->id . ')">Delete</button>';
                        return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
    }
}
    function delete_contact(Request $request){
        $delete['status'] = 0;
        $delete['msg'] = "Oops ! Contact Not Deleted";
        $delete_id = $request->input('id');
        $del_q = Contact::where('id',$delete_id)->delete();
        if($del_q){
            $delete['status'] = 1;
            $delete['msg'] = "Contact Deleted Successfully";
        }

        echo json_encode($delete);
        exit();
    }
}