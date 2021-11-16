<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\Cms;
use Illuminate\Support\Facades\Hash;
use DB;
use DataTables;
use Validator;
use Datetime;
use DateTimeZone;


class CmsController extends Controller
{
    public function cmsform()
    {
        return view('Admin/cms/addcmsform');
    }


    public function addcms(Request $request)
    {
        $update_id = $request->input('hid');
        $validation = Validator::make($request->all(), [
            'title'             => 'required',
            'slug'              => 'required|unique:cms,id,'.$update_id,
            'description'       => 'required',
            // 'metatitle'         => 'required',
            // 'metakeyword'       => 'required',
            // 'metadescription'   => 'required',
            // 'status'            => 'required',
        ]);
        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }
        $CmsData = $request->all();
        $result['status'] = 0;
        $result['msg'] = "Please enter valid data";
        $cms = new Cms();
        if ($update_id == '' && $update_id == null) {
            $cms->title             = $CmsData['title'];
            $cms->slug              = $CmsData['slug'];
            $cms->descriptioneditor = $CmsData['description'];
            $cms->metatitle         = $CmsData['metatitle'];
            $cms->metakeyword       = $CmsData['metakeyword'];
            $cms->metadescription   = $CmsData['metadescription'];
            $cms->status            = $CmsData['status'];
            $cms->save();
            $insert_id = $cms->id;
            if ($insert_id > 0) {
                $result['status'] = 1;
                $result['msg'] = "CMS created successfully";
            }
        } else {
            $UpdateDetails = Cms::where('id', $update_id)->first();
            $UpdateDetails->title             = $CmsData['title'];
            // $UpdateDetails->slug              = $CmsData['slug'];
            $UpdateDetails->descriptioneditor = $CmsData['description'];
            $UpdateDetails->metatitle         = $CmsData['metatitle'];
            $UpdateDetails->metakeyword       = $CmsData['metakeyword'];
            $UpdateDetails->metadescription   = $CmsData['metadescription'];
            $UpdateDetails->status            = $CmsData['status'];
            $UpdateDetails->save();
            $result['status'] = 1;
            $result['msg'] = "CMS Updated successfully";
        }

        echo json_encode($result);
        exit;
    }

    public function cmslist()
    {
        return view('Admin/cms/cmslist');
    }
    public function cmslistdatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Cms::select('id', 'title', 'slug', 'status');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $status = "Inactive";
                    if ($row->status == 1) {
                        $status = "Active";
                    }
                    return $status;
                })
                // ->addColumn('created_at', function($row){   
                //     $utc = $row->created_at;
                //     $dt = new DateTime($utc);
                //     $tz = new DateTimeZone('Asia/Kolkata');
                //     $dt->setTimezone($tz);
                //     $old_date = $dt->format('Y-m-d H:i:s');
                //     $new_date = date("d-F-Y", strtotime($old_date));
                //     return $new_date;

                // })
                ->addColumn('action', function ($row) {
                    $action = '<input type="button" value="Delete" class="btn btn-danger" onclick="delete_cms(' . $row->id . ')">';
                    $action .= '  <a href="' . route("admin-cms-edit", ["id" => $row->id]) . '" class="btn btn-primary "  data-id = "' . $row->id . '">Edit</a>';
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    function deletecmsdata(Request $request)
    {
        $delete_id = $request->input('id');
        $result['status'] = 0;
        $result['msg'] = "Oops ! Cms not Deleted !";
        if (!empty($delete_id)) {
            $del_sql = Cms::where('id', $delete_id)->delete();
            if ($del_sql) {
                $result['status'] = 1;
                $result['msg'] = "Cms Deleted Successfully";
            }
        }
        echo json_encode($result);
        exit;
    }

    public function editcmsdata($id)
    {
        if (!empty($id)) {
            $edit_sql = Cms::where('id', $id)->first();
            if ($edit_sql) {
                $Cms_edit_data['edit_cms'] = $edit_sql;
                return view('Admin/cms/addcmsform')->with($Cms_edit_data);
            }
        }
    }
    public function checkslug(Request $request)
    {
        $slug = $request->input('slug');
        $hid = $request->input('hid');
        $checkslug = Cms::where('slug', '=', $slug);
        if ($hid > 0) {
            $checkslug->where('id', '!=', $hid);
        }
        $checkslugcount = $checkslug->count();
        if ($checkslugcount > 0) {
            echo json_encode(FALSE);
        } else {
            echo json_encode(TRUE);
        }
    }
}
