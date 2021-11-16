<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PopularSearch;
use Carbon\Carbon;
use DataTables;
use Validator;


class PopularSearchController extends Controller
{
    public function popular_search()
    {
        return view('Admin/popular_search/popular_search_index');
    }


    public function add_popular_search(Request $request){
        $validation = Validator::make($request->all(), [
            'popularSearch' => 'required',
            // 'status' => 'required',
        ]);

        if ($validation->fails()) {

            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }
        $update_id = $request->input('hid');
        $popularSearchData = $request->all();
        $result['status'] = 0;
        $result['msg'] = "Please enter valid data";
        $insertdata = new PopularSearch;
        if ($update_id == '' && $update_id == null) {
            $insertdata->popular_search       = $popularSearchData['popularSearch'];
            $insertdata->status               = $popularSearchData['status'];
            $insertdata->created_at           = Carbon::now();
            $insertdata->save();
            $insert_id = $insertdata->id;
            if ($insert_id > 0) {
                $result['status'] = 1;
                $result['msg'] = "Popular Search created successfully";
                $result['id'] = $insert_id;
            }
        } else {
            $UpdateDetails = PopularSearch::where('id', $update_id)->first();
            $UpdateDetails->popular_search      = $popularSearchData['popularSearch'];
            $UpdateDetails->status              = $popularSearchData['status'];
            $UpdateDetails->updated_at          = Carbon::now();
            $UpdateDetails->save();
            $result['status'] = 1;
            $result['msg'] = "Popular Search Updated Successfully!";
        }

        echo json_encode($result);
        exit;
    }


    public function popular_search_datatable(Request $request){
        if ($request->ajax()) {
            $data = PopularSearch::select('id', 'popular_search', 'status');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $status = "Inactive";
                    if ($row->status == 1) {
                        $status = "Active";
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $action = '<input type="button"  value="Delete" class="btn btn-danger " onclick="delete_popular_search(' . $row->id . ')">';
                    $action .= '  <input type="button" value="Edit" class="btn btn-primary"  onclick="edit_popular_search(' . $row->id . ')">';
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    function delete_popular_searchdata(Request $request){
        $delete_id = $request->input('id');
        $result['status'] = 0;
        $result['msg'] = "Oops ! Popular Search not Deleted !";

        if (!empty($delete_id)) {
            $del_sql = PopularSearch::where('id', $delete_id)->delete();
            if ($del_sql) {
                $result['status'] = 1;
                $result['msg'] = "Popular Search Deleted Successfully";
            }
        }
        echo json_encode($result);
        exit;
    }

    public function edit_popular_searchdata(Request $request){
        $edit_id = $request->input('id');
        $responsearray = array();
        $responsearray['status'] = 0;
        if (!empty($edit_id)) {
            $edit_sql = PopularSearch::where('id', $edit_id)->first();
            if ($edit_sql) {
                $responsearray['status'] = 1;
                $responsearray['popularSearch'] = $edit_sql;
            }
        }
        echo json_encode($responsearray);
        exit;
    }
}
