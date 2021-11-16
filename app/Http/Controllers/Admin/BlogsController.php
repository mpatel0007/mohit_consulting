<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\Companies;
use App\Models\Industries;
use App\Models\City;
use App\Models\State;
use App\Models\Companycity;
use App\Models\Companyindustry;
use App\Models\Country;
use App\Models\Package;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Blogs;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use DataTables;


class BlogsController extends Controller
{
    public function blogsform()
    {
        return view('Admin/blogs/addblogform');
    }

    public function addblog(Request $request){
        try {
            $validation = Validator::make($request->all(), [
                'bloglog'           => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'title'             => 'required',
                'description'       => 'required'
            ]);
            $update_id = $request->input('hid');        

            if ($validation->fails()) {
                $data['status'] = 0;      
                $data['error'] = $validation->errors()->all();
                echo json_encode($data);
                exit();
            }   
            $update_id = $request->input('hid');  
            $blogsData = $request->all();

            $image = $request->file('bloglog');
            if(!empty($image)){
                $image_name = time().'.'.$image->getClientOriginalExtension();        
                $destinationPath = public_path('assets/admin/blogs/');
                $blogdetailsPath = public_path('assets/admin/blogs/blog_details/');
                $image_resize = Image::make($image->getRealPath());              
                $image_resize_full = Image::make($image->getRealPath());              
                $image_resize->resize(350,233);
                if(!empty($image_name)){
                    $image_resize->save($destinationPath . $image_name);  
                }
                $image_resize_full->resize(730,null,function ($constraint) {
                    $constraint->aspectRatio();
                });
                if(!empty($image_name)){
                    $image_resize_full->save($blogdetailsPath . $image_name);  
                }
            }
            $result['status'] = 0;
            $result['msg'] = "Please enter valid data";
            $blogs = new Blogs();
            if($update_id == '' && $update_id == null){
                $blogs->image       = !empty($image_name) ? $image_name : " ";
                $blogs->title       = $blogsData['title'];
                $blogs->description      = $blogsData['description'];
                $blogs->status            = $blogsData['status'];
                $blogs->created_at = Carbon::now();
                $blogs->save();
                $insert_id = $blogs->id;
                if($insert_id > 0) {
                    $result['status'] = 1;
                    $result['msg'] = "Blog inserted successfully";
                }
            }else{
                $UpdateDetails = Blogs::where('id',$update_id)->first();
                $UpdateDetails->image       = !empty($image_name) ? $image_name : $UpdateDetails->image;
                $UpdateDetails->title       = $blogsData['title'];
                $UpdateDetails->description = $blogsData['description'];
                $UpdateDetails->status      = $blogsData['status'];
                $UpdateDetails->updated_at = Carbon::now();
                $UpdateDetails->save();    
                $result['status'] = 1;
                $result['msg'] = "Blog Updated successfully";
            }    
        } catch (Throwable $e) { 
          $result['status'] = 0;
          $result['msg'] = $e->getMessage();
      }
      echo json_encode($result);
      exit;
  }

  public function blogslist(){
    return view('Admin/blogs/blogslist');
} 

public function blogslistdatatable(Request $request){

    if ($request->ajax()) {
        $data = Blogs::select('id','title','description','image','status','created_at');

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
            $action = '<input type="button" value="Delete" class="btn btn-danger " onclick="delete_blogs(' . $row->id . ')">';    
            $action .= '  <a href="'. route("admin-blogs-edit", ["id" => $row->id]).'" class="btn btn-primary"  data-id = "' . $row->id . '">Edit</a>';       
            return $action;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
}


function deleteblogsdata(Request $request){
    $delete_id = $request->input('id'); 
    $result['status'] = 0;
    $result['msg'] = "Oops ! Blog not deleted !";
    if(!empty($delete_id)){
        $del_sql = Blogs::where('id',$delete_id)->delete();
        if($del_sql){  
            $result['status'] = 1;
            $result['msg'] = "Blog Deleted Successfully";
        }
    }
    echo json_encode($result);
    exit;
}

public function editblogsdata($id){
    if(!empty($id)){
        $edit_sql = Blogs::where('id',$id)->first();
        if(!empty($edit_sql)){
            $blogsData = $edit_sql;
            return view('Admin/blogs/addblogform')->with(compact('blogsData'));
        }
    }
}

}