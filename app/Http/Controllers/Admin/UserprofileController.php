<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\Userprofile;
use App\Models\Industries;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\Jobskill;
use App\Models\Degreelevel;
use App\Models\Userprofileskilllevel;
use App\Models\Userprofiledegreelevel;
use App\Models\Careerlevel;
use App\Models\Functional_area;
use App\Models\Userprofilefunctionalarea;
use App\Models\Salary;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Hash;
use Validator;
use DB;
use Response;


use DataTables;

class UserprofileController extends Controller
{
    public function userprofileform()
    {
        $industry = Industries::select('id', 'industry_name')->get();
        $country = Country::select('id', 'country_name')->get();
        $career =  Careerlevel::select('id', 'careerlevel')->get();
        $functional_area = Functional_area::select('id', 'functional_area')->get();
        $jobskill =     Jobskill::select('id', 'jobskill')->get();
        $degreelevel =  Degreelevel::select('id', 'degreelevel')->get();
        $salaries =  Salary::select('id', 'salary')->get();
        return view('Admin/userprofile/adduserprofile')->with(compact('country', 'degreelevel', 'jobskill', 'industry', 'career', 'functional_area', 'salaries'));
    }

    public function adduserprofile(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'fname'             => 'required',
            // 'mname'             => 'required',
            'lname'             => 'required',
            // 'email'             => 'required|email|unique:users',
            'dob'               => 'required',
            'gender'            => 'required',
            // 'marital'           => 'required',
            'country'           => 'required',
            'state'             => 'required',
            'city'              => 'required',
            // 'mobile'            => 'required',
            'experience'        => 'required',
            'career'            => 'required',
            'industry'          => 'required',
            'subCategory'        => 'required',
            // 'csalary'           => 'required',
            // 'esalary'           => 'required',
            // 'strretaddress'     => 'required',
            // 'status'            => 'required',
        ]);
        $update_id = $request->input('hid');
        if (empty($update_id)) {
            $validation->password     = 'required';
            $validation->email        = 'required|email|unique:users';
        }
        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }
        $UserprofileData = $request->all();
        $update_id = $request->input('hid');
        // File upload companylogo
        $image = $request->croppedImageDataURL;
        
        // if (!empty($image)) {
        //     $image_name = time() . '.' . $image->getClientOriginalExtension();
        //     $destinationPath = public_path('assets/admin/userprofileImg/');
        //     $image_resize = Image::make($image->getRealPath());
        //     $image_resize->resize(300, 200);
        //     if (!empty($image_name)) {
        //         $image_resize->save($destinationPath . $image_name, 80);
        //     }
        // }
        $result['status'] = 0;
        $result['msg'] = "Please enter valid data";
        $Userprofile = new Userprofile();
        if ($update_id == '' && $update_id == null) {
            $Userprofile->profileimg         = !empty($image) ? $image : " ";
            $Userprofile->name              = $UserprofileData['fname'];
            $Userprofile->mname              = $UserprofileData['mname'];
            $Userprofile->lname              = $UserprofileData['lname'];
            $Userprofile->email              = $UserprofileData['email'];
            $Userprofile->password           = Hash::make($UserprofileData['password']);
            // $Userprofile->fathername       = $UserprofileData['fathername'];
            $Userprofile->dateofbirth        = $UserprofileData['dob'];
            $Userprofile->gender             = $UserprofileData['gender'];
            $Userprofile->maritalstatus      = $UserprofileData['marital'];
            $Userprofile->country_id         = $UserprofileData['country'];
            $Userprofile->state_id           = $UserprofileData['state'];
            $Userprofile->city_id            = $UserprofileData['city'];
            $Userprofile->phone              = $UserprofileData['phone'];
            $Userprofile->mobile             = $UserprofileData['mobile'];
            $Userprofile->experience         = $UserprofileData['experience'];
            $Userprofile->jobskill_id         = $UserprofileData['jobskill'];
            $Userprofile->careerlevel        = $UserprofileData['career'];
            $Userprofile->industry_id        = $UserprofileData['industry'];
            // $Userprofile->functional_id      = $UserprofileData['functional'];
            $Userprofile->currentsalary      = $UserprofileData['csalary'];
            $Userprofile->expectedsalary     = $UserprofileData['esalary'];
            $Userprofile->streetaddress      = $UserprofileData['strretaddress'];
            $Userprofile->userstatus         = $UserprofileData['status'];
            $Userprofile->active_inactive    = $UserprofileData['status'];
            $Userprofile->save();
            $insert_id = $Userprofile->id;
            if ($insert_id > 0) {
                $result['status'] = 1;
                $result['msg'] = "Employee inserted Successfully";
            }

            if ($insert_id != '' && $insert_id != null) {
                DB::table('companies')->insert([
                  'user_id' => $insert_id
                ]);    

                $Userprofile_functionalarea =  $UserprofileData['subCategory'];
                if ($Userprofile_functionalarea != '' && $Userprofile_functionalarea != null) {
                    foreach ($Userprofile_functionalarea as $key => $functional_area_id) {
                        $Userprofilefunctionalarea = new Userprofilefunctionalarea();
                        $Userprofilefunctionalarea->userprofile_id          = $insert_id;
                        $Userprofilefunctionalarea->functional_area_id      = $functional_area_id;
                        $Userprofilefunctionalarea->save();
                    }
                }

                $allDegreelevel =  $UserprofileData['degreelevel'];
                if ($allDegreelevel != '' && $allDegreelevel != null) {
                    foreach ($allDegreelevel as $key => $Degreelevel_id) {
                        $Userprofiledegreelevel = new Userprofiledegreelevel();
                        $Userprofiledegreelevel->userprofile_id      = $insert_id;
                        $Userprofiledegreelevel->degreelevel_id      = $Degreelevel_id;
                        $Userprofiledegreelevel->save();
                    }
                }
                if (isset($UserprofileData['skill']) && isset($UserprofileData['level'])) {
                    $skill_ids = $UserprofileData['skill'];
                    $level_ids = $UserprofileData['level'];
                    if ($skill_ids != "" && $level_ids != "") {
                        foreach ($skill_ids as $key => $skill_id) {
                            $Userprofileskilllevel = new Userprofileskilllevel();
                            $Userprofileskilllevel->userprofile_id      = $insert_id;
                            $Userprofileskilllevel->skill_id            = $skill_id;
                            $Userprofileskilllevel->level_id            = $level_ids[$key];
                            $Userprofileskilllevel->save();
                        }
                    } else {
                        $result['status'] = 0;
                        $result['msg'] = "Select Job skill and career level";
                    }
                }
            }
        } else {
            $UpdateDetails = Userprofile::where('id', $update_id)->first();
            $UpdateDetails->profileimg         = !empty($image) ? $image : $UpdateDetails->profileimg;
            $UpdateDetails->name               = $UserprofileData['fname'];
            $UpdateDetails->mname              = $UserprofileData['mname'];
            $UpdateDetails->lname              = $UserprofileData['lname'];
            $UpdateDetails->email              = $UserprofileData['email'];
            $UpdateDetails->password           = !empty($UserprofileData['password']) ? Hash::make($UserprofileData['password']) : $UpdateDetails->password;
            // $UpdateDetails->fathername       = $UserprofileData['fathername'];
            $UpdateDetails->dateofbirth        = $UserprofileData['dob'];
            $UpdateDetails->gender             = $UserprofileData['gender'];
            $UpdateDetails->maritalstatus      = $UserprofileData['marital'];
            $UpdateDetails->country_id         = $UserprofileData['country'];
            $UpdateDetails->state_id           = $UserprofileData['state'];
            $UpdateDetails->city_id            = $UserprofileData['city'];
            $UpdateDetails->phone              = $UserprofileData['phone'];
            $UpdateDetails->mobile             = $UserprofileData['mobile'];
            $UpdateDetails->experience         = $UserprofileData['experience'];
            $UpdateDetails->careerlevel        = $UserprofileData['career'];
            $UpdateDetails->industry_id        = $UserprofileData['industry'];
            // $UpdateDetails->functional_id      = $UserprofileData['functional'];
            $UpdateDetails->currentsalary      = $UserprofileData['csalary'];
            $UpdateDetails->expectedsalary     = $UserprofileData['esalary'];
            $UpdateDetails->streetaddress      = $UserprofileData['strretaddress'];
            $UpdateDetails->userstatus         = $UserprofileData['status'];
            $UpdateDetails->active_inactive    = $UserprofileData['status'];
            $UpdateDetails->jobskill_id         = $UserprofileData['jobskill'];
            $UpdateDetails->save();
            $result['status'] = 1;
            $result['msg'] = "Employee Updated Successfully";
            if ($update_id != '' && $update_id != null) {
                $del_Userprofiledegreelevel  = Userprofiledegreelevel::where('userprofile_id', $update_id)->delete();
                $del_Userprofileskilllevel  = Userprofileskilllevel::where('userprofile_id', $update_id)->delete();
                $del_Userprofilefunctionalarea  = Userprofilefunctionalarea::where('userprofile_id', $update_id)->delete();

                $allDegreelevel =  $UserprofileData['degreelevel'];
                if ($allDegreelevel != '' && $allDegreelevel != null) {
                    foreach ($allDegreelevel as $key => $Degreelevel_id) {
                        $Userprofiledegreelevel = new Userprofiledegreelevel();
                        $Userprofiledegreelevel->userprofile_id      = $update_id;
                        $Userprofiledegreelevel->degreelevel_id      = $Degreelevel_id;
                        $Userprofiledegreelevel->save();
                    }
                }

                $Userprofile_functionalarea =  $UserprofileData['subCategory'];
                if ($Userprofile_functionalarea != '' && $Userprofile_functionalarea != null) {
                    foreach ($Userprofile_functionalarea as $key => $functional_area_id) {
                        $Userprofilefunctionalarea = new Userprofilefunctionalarea();
                        $Userprofilefunctionalarea->userprofile_id          = $update_id;
                        $Userprofilefunctionalarea->functional_area_id      = $functional_area_id;
                        $Userprofilefunctionalarea->save();
                    }
                }

                if (isset($UserprofileData['skill']) && isset($UserprofileData['level'])) {
                    $skill_ids = $UserprofileData['skill'];
                    $level_ids = $UserprofileData['level'];
                    if ($skill_ids != "" && $level_ids != "") {
                        foreach ($skill_ids as $key => $skill_id) {
                            $Userprofileskilllevel = new Userprofileskilllevel();
                            $Userprofileskilllevel->userprofile_id        = $update_id;
                            $Userprofileskilllevel->skill_id              = $skill_id;
                            $Userprofileskilllevel->level_id              = $level_ids[$key];
                            $Userprofileskilllevel->save();
                        }
                    } else {
                        $result['status'] = 0;
                        $result['msg'] = "Select Job skill and career level";
                    }
                }
            }
        }
        echo json_encode($result);
        exit;
    }

    public function emailcheck(Request $request){
        $email = $request->all();
        $user_email = $email['email'];
        $hid = $request->input('hid');

        $find_user = Userprofile::where('email', '=', $user_email);
        if ($hid > 0) {
            $find_user->where('id', '!=', $hid);
        }
        $result = $find_user->count();
        if ($result > 0) {
            echo json_encode(FALSE);
        } else {
            echo json_encode(true);
        }
    }

    public function userprofilelist()
    {
        return view('Admin/userprofile/userprofilelist');
    }

    public function userprofilelistdatatable(Request $request)
    {
        if ($request->ajax()) {
            // $data = Userprofile::select('id','mname','email','userstatus');
            $data =  DB::table('users')
                     ->select('users.*')
                     ->where('is_admin', 0);
                    
            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('userstatus', function ($row) {
                    $status = "Inactive";
                    if ($row->active_inactive == '1') {
                        $status = "Active";
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $action = '<input type="button" value="Delete" class="btn btn-danger " onclick="delete_userprofile(' . $row->id . ')">';
                    $action .= '  <a href="' . route("admin-userprofile-edit", ["id" => $row->id]) . '" class="btn btn-primary"  data-id = "' . $row->id . '">Edit</a>';
                    $action .= '  <a href="' . route("admin-subscriptions-view", ["id" => $row->id]) . '" class="btn btn-secondary"  data-id = "' . $row->id . '">Subscriptions</a>';
                    $action .= ' <input type="button" value="Uploaded Document" class="btn btn-success UploadedDocument" data-id = "' . $row->id . '">';
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function subscriptions_view($id)
    {
        $userId = $id;
        return view('Admin/userprofile/subscriptions')->with(compact('userId'));
    }

    public function candidate_resume_dowload(Request $request){
        $Userprofile = Userprofile::where('id', $request->user_id)->first();
        if($Userprofile->resume != '' & $Userprofile->resume != ''){
          $file = public_path('assets/front_end/Upload/User_Resume/'.$Userprofile->resume.'');
          if($file != '' & $file != null){
            // return Response::download($file);
            $result['filename'] = $Userprofile->resume;
            $result['status'] = 1;
            $result['msg'] = "Resume Download sucessfully.";
            // $result['file'] = $file;
            // return response()->download($file);
            } else{
                $result['status'] = 0;
                $result['msg'] = "Error !! Resume Not Found.";
            }
        }else{
            $result['status'] = 0;
            $result['msg'] = "Error !! Resume Not Uploaded.";
        }
        echo json_encode($result);
        exit;
    }

    public function candidate_coverletter_dowload(Request $request){
        $Userprofile = Userprofile::where('id', $request->user_id)->first();
        if($Userprofile->coverletter != '' & $Userprofile->coverletter != ''){
          $file = public_path('assets/front_end/Upload/User_Cover_Letter/'.$Userprofile->coverletter.'');
          if($file != '' & $file != null){
            $result['filename'] = $Userprofile->coverletter;
            $result['status'] = 1;
            $result['msg'] = "Cover Letter Download sucessfully.";

            }else{
                $result['status'] = 0;
                $result['msg'] = "Error !! Cover Letter Not Found.";
            }
        }else{
            $result['status'] = 0;
            $result['msg'] = "Error !! Cover Letter Not Uploaded.";
        }
        echo json_encode($result);
        exit;
    }

    public function candidate_references_dowload(Request $request){
        $Userprofile = Userprofile::where('id', $request->user_id)->first();
        if($Userprofile->references != '' & $Userprofile->references != ''){
          $file = public_path('assets/front_end/Upload/User_References/'.$Userprofile->references.'');
          if($file != '' & $file != null){
            $result['filename'] = $Userprofile->references;
            $result['status'] = 1;
            $result['msg'] = "References Download sucessfully.";
            }else{
                $result['status'] = 0;
                $result['msg'] = "Error !! References Not Found.";
            }
        }else{
            $result['status'] = 0;
            $result['msg'] = "Error !! References Not Uploaded.";
        }
        echo json_encode($result);
        exit;
    }
    public function subscriptions_list(Request $request)
    {

        if ($request->ajax()) {
            $data =  DB::table('subscriptions')
                ->select('subscriptions.*', 'package.package_title as package_name', 'package.package_price as package_price')
                ->leftjoin("package", "subscriptions.name", "=", "package.id")
                ->where('subscriptions.user_id', $request->userId);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('start_at', function ($row) {
                    $oldDate = $row->start_at;
                    $start_at = date("F j, Y", strtotime($oldDate));
                    return $start_at;
                })
                ->addColumn('ends_at', function ($row) {
                    $oldDate = $row->ends_at;
                    $ends_at = date("F j, Y", strtotime($oldDate));
                    return $ends_at;
                })
                ->addColumn('action', function ($row) {
                    // $action = '  <a href="' . route("admin-userprofile-edit", ["id" => $row->id]) . '" class="btn btn-primary viewCharge"  data-id = "' . $row->id . '">View Charge</a>';
                    $action = '<input type="button" value="View Charge" class="btn btn-primary viewCharge" data-id = "' . $row->stripe_id . '">';
                    return $action;
                })
                ->rawColumns(['action', 'ends_at', 'start_at'])
                ->make(true);
        }
    }

    public function subscriptions_charge_list(Request $request)
    {
        $stripe_id = $request->input('stripe_id');
        $responsearray = array();
        $responsearray['status'] = 0;
        if (!empty($stripe_id)) {
            $getDatasql = DB::table('subscription_charges')
                ->select('subscription_charges.*', 'subscriptions.name as package_id', 'package.package_price as package_price')
                ->leftjoin("subscriptions", "subscription_charges.subscription_id", "=", "subscriptions.stripe_id")
                ->leftjoin("package", "subscriptions.name", "=", "package.id")
                ->where('subscription_charges.subscription_id', $stripe_id)
                ->get()->toArray();
            // ->toSql();
            $table =
                '<table class="table table-hover table-sm">
                            <tr class="thead-dark">
                                <th scope="col">Charge ID</th>
                                <th scope="col">Created Date</th>
                                <th scope="col">Amount</th>
                            </tr>';
                      
            if(isset($getDatasql)){
                foreach ($getDatasql as $Datasql) {
                    $chargeId = "No data";
                    if($Datasql->charge_id != '' && $Datasql->charge_id != null){
                        $chargeId = $Datasql->charge_id;
                    }
    
                    $package_price = "No data";
                    if($Datasql->package_price != '' && $Datasql->package_price != null){
                        $package_price = $Datasql->package_price;
                    }
                    
                    $created_at = "No data";
                    if($Datasql->created_at != '' && $Datasql->created_at != null){
                        $oldDate = $Datasql->created_at;
                        $created_at = date("F j, Y", strtotime($oldDate));
                    }        
    
                    $table .= '     <tr style="margin-left: 10px;">
                                        <td>' . $chargeId . '</td> 
                                        <td> ' . $created_at . '</td> 
                                        <td>' . $package_price . ' </td>
                                    </td>';
                }
                    $table .= '</tr>
                                </table>';
            }else{
                $table .=  '<tr>
                <td colspan="3" style="text-align: center">No Data available</td>
                    </tr>
                        </table>';
            }
          

                $responsearray['status'] = 1;
                $responsearray['table'] = $table;
        }
        echo json_encode($responsearray);
        exit;
    }




    public function deleteuserprofiledata(Request $request)
    {
        $delete_id = $request->input('id');
        $result['status'] = 0;
        $result['msg'] = "Employee not Deleted !";
        if (!empty($delete_id)) {
            $del_sql = Userprofile::where('id', $delete_id)->delete();
            if ($del_sql) {
                $result['status'] = 1;
                $result['msg'] = "Employee Deleted Successfully";
            }
        }
        echo json_encode($result);
        exit;
    }

    public function edituserprofiledata($id)
    {
        if (!empty($id)) {
            $edit_sql = Userprofile::where('id', $id)->first();

            if (!empty($edit_sql)) {
                $Userprofiledegreelevel = Userprofiledegreelevel::where('userprofile_id', $id)->get();
                $Filldegreelevel_id = array();
                foreach ($Userprofiledegreelevel as $degreelevel_id) {
                    $Filldegreelevel_id[] =  $degreelevel_id['degreelevel_id'];
                }
                $Userprofilefunctionalarea = Userprofilefunctionalarea::where('userprofile_id', $id)->get()->toArray();
                $Userprofilefunctionalarea_id = array();
                foreach ($Userprofilefunctionalarea as $functionalarea_id) {
                    $Userprofilefunctionalarea_id[] =  $functionalarea_id['functional_area_id'];
                }
                $getSkill = Userprofileskilllevel::where('userprofile_id', $id)->get();
                $Fillskill_id = array();
                $Filllevel_id = array();
                $count = 0;
                foreach ($getSkill as $skill_id) {
                    $Fillskill_id[] = $skill_id['skill_id'];
                    $Filllevel_id[] = $skill_id['level_id'];
                    $count = count($Filllevel_id);
                }

                $Userprofile_edit_data = $edit_sql;

                $industry = Industries::select('id', 'industry_name')->get();
                $country = Country::select('id', 'country_name')->get();
                $selected_country = $Userprofile_edit_data->country_id;
                $selected_state = $Userprofile_edit_data->state_id;
                $state = State::where('country_id', $selected_country)->get();
                $degreelevel =  Degreelevel::select('id', 'degreelevel')->get();
                $jobskill =  Jobskill::select('id', 'jobskill')->get();
                $city = City::where('state_id', $selected_state)->get();
                // $subCategories = Functional_area::where('industry_id',$Userprofile_edit_data->industry_id)->get();
                $subCategories  = Functional_area::where('industry_id', isset($Userprofile_edit_data->industry_id) ? $Userprofile_edit_data->industry_id : '')->get();

                $career =  Careerlevel::select('id', 'careerlevel')->get();
                $salaries =  Salary::select('id', 'salary')->get();
                // $functional_area = Functional_area::select('id', 'functional_area')->get();
                return view('Admin/userprofile/adduserprofile')->with(compact('Userprofile_edit_data', 'count', 'subCategories', 'Userprofilefunctionalarea_id', 'degreelevel', 'Fillskill_id', 'Filllevel_id', 'Filldegreelevel_id', 'career', 'jobskill', 'industry', 'city', 'state', 'country', 'salaries'));
            }
        }
    }
}
