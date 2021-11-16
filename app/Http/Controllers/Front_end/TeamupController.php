<?php

namespace App\Http\Controllers\Front_end;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Userprofile;
use App\Models\Teamname;
use App\Models\Teamtask;
use App\Models\Teamuprequest;
use App\Models\Candidatetask;
use App\Models\Industries;
use App\Models\Jobskill;
use App\Models\Emailtemplate;
use Mail;
use Validator;
use DB;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\Cloner\Data;
use Carbon\Carbon;
use App\Helper\Helper;

class TeamupController extends Controller
{

    public function teamup_list_view(Request $request)
    {
        Helper::isSubscribed();
        return view('Front_end/candidate/ManageProfile/teamup_list');
    }

    public  function team_up_action_view(Request $request)
    {
        Helper::isSubscribed();
        return view('Front_end/candidate/ManageProfile/team_up_action');
    }


    public function new_teamup(Request $request, $team_id = null){
        Helper::isSubscribed();
        $Teamuprequest = Teamuprequest::select()->first();
        $CandidatesSql  = DB::table('users')
        ->select('users.*', 'jobskill.jobskill as jobskill')
        ->leftjoin("jobskill", "jobskill.id", "=", "users.jobskill_id")
        ->where('users.id', '!=', Auth::guard('candidate')->id());

        $Candidates = $CandidatesSql->paginate(4);
        $jobskill   = DB::table('userprofile_skilllevel')
        ->select('userprofile_skilllevel.*', 'jobskill.jobskill as jobskill',)
        ->leftjoin("jobskill", "jobskill.id", "=", "userprofile_skilllevel.skill_id")
        ->get();
        $teamID = $team_id;

        $Candidates  = DB::table('users')
        ->select('users.*', 'jobskill.jobskill as jobskill')
        ->leftjoin("jobskill", "jobskill.id", "=", "users.jobskill_id")
        ->where('users.id', '!=', Auth::guard('candidate')->id())
            // ->get()->toArray();
        ->paginate(4);

        $team_details = DB::table('teamup_request')
        ->select('teamup_request.*', 'team_name.team_name as team_name', 'users.name as candidate_name')
        ->leftjoin("team_name", "team_name.id", "=", "teamup_request.team_id")
        ->leftjoin("users", "users.id", "teamup_request.candidate_id")
        ->where("team_id", $team_id)
        ->get()->toArray();

        $categories = Industries::select('id', 'industry_name')->where('status','1')->get();
        $alljobskills = Jobskill::select('id', 'jobskill')->where('status','1')->get();
        
        return view('Front_end/candidate/ManageProfile/new_teamup')->with(compact('Candidates','categories','jobskill','alljobskills','Teamuprequest', 'teamID', 'team_details'));
    }

    public function new_teamup_search(Request $request, $searchCandidate = null)
    {   
        $team_id = $request->teamid;
        Helper::isSubscribed();
        $Teamuprequest = Teamuprequest::select()->first();  
        $searchCandidate = $request->searchCandidate;
        $CandidatesSql  = DB::table('users')
                                ->select('users.*','jobskill.jobskill as jobskill')
                                ->leftjoin("jobskill", "users.jobskill_id", "=", "jobskill.id")
                                ->where('users.id', '!=', Auth::guard('candidate')->id());
            if (isset($searchCandidate) && $searchCandidate != '' && $searchCandidate != 'undefined') {
                    $CandidatesSql->where(function ($query) use ($searchCandidate) {
                            $query->where('users.name', 'LIKE', "%".$searchCandidate."%");
                            $query->orWhere('users.industry_id', 'LIKE', "%".$searchCandidate."%");
                            $query->orWhere('jobskill', 'LIKE', "%".$searchCandidate."%");
                    }); 
            }

        $Candidates = $CandidatesSql->paginate(4);
        $teamID = $team_id;
        $jobskill   = DB::table('userprofile_skilllevel')
                    ->select('userprofile_skilllevel.*', 'jobskill.jobskill as jobskill')
                    ->leftjoin("jobskill", "jobskill.id", "=", "userprofile_skilllevel.skill_id")
                    ->get();
        
        $team_details = DB::table('teamup_request')
                    ->select('teamup_request.*', 'team_name.team_name as team_name','users.name as candidate_name')
                    ->leftjoin("team_name", "team_name.id", "=", "teamup_request.team_id")
                    ->leftjoin("users", "users.id", "teamup_request.candidate_id")
                    ->where("team_id", $team_id)
                    ->get()->toArray();
                
        return view('Front_end/candidate/ManageProfile/team_candidate_list')->with(compact('Candidates','team_id','jobskill','teamID','Teamuprequest','team_details'))->render();
        $result['CandidatesList'] = $Candidates;
        echo json_encode($result);
        exit;
    }

    public function team_request_message(Request $request){
        $teamID = $request->input('team_id');
        $responsearray['status'] = 0;
        $responsearray['msg'] = "team up request message";
        if($teamID != '' && $teamID != null){
            $requestDescription = Teamuprequest::where('candidate_id',Auth::guard('candidate')->id())->where('team_id',$teamID)->get();
            $description = $requestDescription[0]->description;
            $responsearray['status'] = 1;
            $responsearray['message'] = $description;
        }
        echo json_encode($responsearray);
        exit;
    }
    public function team_list(Request $request)
    {
        if ($request->ajax()) {
            // $data = DB::table('teamup_request')
            //        ->select('teamup_request.*','team_name.team_name as team_name','users.name as candidate_name')
            //        ->leftjoin("team_name", "team_name.id", "=", "teamup_request.team_id")
            //        ->leftjoin("users","users.id","teamup_request.candidate_id")
            //        ->where("team_creator",Auth::guard('candidate')->id())
            //        ->get()->toArray();
            // ->toSql();

            $data = Teamname::where('team_creator', Auth::guard('candidate')->id())->get();

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $action  = "<button class='edit_job' data-toggle='tooltip' title='Team Members'><a href=" . route('front_end-candidate-members-view', ['team_id' => $row->id]) . "><i class='fa fa-users' style='color:#21254C' aria-hidden='true'></i></a></button>";
                $action  .= "<button class='edit_job' data-toggle='tooltip' title='Add new members'><a href=" . route('front_end-candidate-new-teamup', ['team_id' => $row->id]) . "><i class='fa fa-plus-square' style='color:#21254C' aria-hidden='true'></i></a></button>";
                $action .= "<button class='edit_job' data-toggle='tooltip' title='Edit team' onclick='edit_team(" . $row->id . ")'><i class='fa fa-pencil-square' style='color:#21254C' aria-hidden='true'></i></button>";
                $action .=  "<button  class='delete_job' data-toggle='tooltip' title='Delete team' onclick='delete_team(" . $row->id . ")'><i class='fa fa-trash' style='color:#21254C' aria-hidden='true'></i></button>";
                return $action;
            })
            ->addColumn('task', function ($row) {
                $task  = "<button class='edit_job' data-toggle='tooltip' title='Add team task' onclick='add_task(" . $row->id . ")'><i class='fa fa-plus-square' style='color:#21254C' aria-hidden='true'></i></button>";
                $task  .= "<button class='edit_job' data-toggle='tooltip' title='Task list '><a href=" . route('front_end-candidate-team-task-view', ['team_id' => $row->id]) . "><i class='fa fa-tasks' style='color:#21254C' aria-hidden='true'></i></a></button>";
                return $task;
            })

            ->addColumn('created_at', function ($row) {
                $oldDate = $row->created_at;
                $newDate = date("F j, Y", strtotime($oldDate));
                return $newDate;
            })
            ->rawColumns(['action', 'created_at', 'task'])
            ->make(true);
        }
    }

    public function team_delete(Request $request)
    {
        Helper::isSubscribed();
        $team_id = $request->team_id;
        $result['status'] = 0;
        $result['msg'] = "Oops ! Team Not Delete !";
        if (!empty($team_id)) {
            $remove_sql = Teamname::where('id', $team_id)->delete();
            if ($remove_sql) {
                $result['status'] = 1;
                $result['msg'] = "Team Delete Successfully";
            }
        }
        echo json_encode($result);
        exit;
    }

    // public function team_edit($team_id){
    //     Helper::isSubscribed();
    //     $Teamuprequest = Teamuprequest::select()->first();
    //     $Candidates    = DB::table('users')
    //     ->select('users.*','jobskill.jobskill as jobskill')
    //     ->leftjoin("jobskill", "jobskill.id", "=", "users.jobskill_id")
    //     ->where('users.id','!=',Auth::guard('candidate')->id())
    //     // ->get()->toArray();
    //     ->paginate(6);
    //     $jobskill      = DB::table('userprofile_skilllevel')
    //     ->select('userprofile_skilllevel.*','jobskill.jobskill as jobskill',)
    //     ->leftjoin("jobskill", "jobskill.id", "=", "userprofile_skilllevel.skill_id")
    //     ->get();
    //     $team_details = DB::table('teamup_request')
    //     ->select('teamup_request.*','team_name.team_name as team_name','users.name as candidate_name')
    //     ->leftjoin("team_name", "team_name.id", "=", "teamup_request.team_id")
    //     ->leftjoin("users","users.id","teamup_request.candidate_id")
    //     ->where("team_id",$team_id)
    //     ->get()->toArray();
    //     return view('Front_end/candidate/ManageProfile/new_teamup')->with(compact('team_details','jobskill','Candidates','Teamuprequest'));
    // }

    public function team_edit(Request $request){
        Helper::isSubscribed();
        $edit_id = $request->input('team_id');
        $responsearray = array();
        $responsearray['status'] = 0;
        if (!empty($edit_id)) {
            $edit_sql = Teamname::where('id', $edit_id)->first();
            if ($edit_sql) {
                $responsearray['status'] = 1;
                $responsearray['admin'] = $edit_sql;
            }
        }
        echo json_encode($responsearray);
        exit;
    }

    public function team_members_list_view($team_id)
    {
        Helper::isSubscribed();
        $team_id = $team_id;
        return view('Front_end/candidate/ManageProfile/team_members_list')->with(compact('team_id'));
    }

    public function team_request_view(Request $request)
    {
        Helper::isSubscribed();
        return view('Front_end/candidate/ManageProfile/team_request_list');
    }

    public function team_joined_view(Request $request)
    {
        Helper::isSubscribed();
        return view('Front_end/candidate/ManageProfile/team_joined_list');
    }

    public function team_members_list(Request $request)
    {
        if ($request->ajax()) {
            $team_id = $request->team_id;
            $data = DB::table('teamup_request')
            ->select('teamup_request.*', 'team_name.team_name as team_name', 'users.name as candidate_name')
            ->leftjoin("team_name", "team_name.id", "=", "teamup_request.team_id")
            ->leftjoin("users", "users.id", "teamup_request.candidate_id")
            ->where("team_id", $team_id)
            ->get()->toArray();

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('candidate_name', function ($row) {
                $candidate_name =  $row->candidate_name;
                $candidate_name =    "<a href=" . route('front_end-candidate_details_view', ['candidate_id' => $row->candidate_id]) . ">$row->candidate_name</a>";
                return $candidate_name;
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    $status = '<nobr><span class="full-time">Request Accept</span></nobr>';
                } else if ($row->status == 0) {
                    $status = '<nobr><span class="part-time">request Deny</span></nobr>';
                } else if ($row->status == 2) {
                    $status = '<nobr><span class="freelance">Requested</span></nobr>';
                }
                return $status;
            })
            ->addColumn('remove_candidate', function ($row) {
                $remove_candidate =  "<button  data-toggle='tooltip' title='Remove from team' class='delete_job' onclick='Remove_members(" . $row->candidate_id . ',' . $row->team_id . ")'><i class='fa fa-trash' style='color:#21254C' aria-hidden='true'></i></button>";
                return $remove_candidate;
            })
            ->addColumn('gave_task', function ($row) {
                $gave_task =  "<button  class='delete_job' data-toggle='tooltip' title='Assign Task' onclick='gave_member_task("  . $row->candidate_id . ',' . $row->team_id . ")'><i class='fa fa-tasks' style='color:#21254C'></i></button>";
                return $gave_task;
            })
            ->rawColumns(['candidate_name','gave_task','remove_candidate', 'status', 'candidate_name'])
            ->make(true);
        }
    }

    public function team_member_remove(Request $request)
    {
        Helper::isSubscribed();
        $candidate_id = $request->candidate_id;
        $team_id = $request->team_id;
        $result['status'] = 0;
        $result['msg'] = "Oops ! Member not remove !";
        if (!empty($candidate_id)) {
            $remove_sql = Teamuprequest::where('candidate_id', $candidate_id)->where('team_id', $team_id)->delete();
            if ($remove_sql) {
                $result['status'] = 1;
                $result['msg'] = "Member remove from team Successfully";
            }
        }
        echo json_encode($result);
        exit;
    }

    public function team_request_list(Request $request)
    {
        if ($request->ajax()) {
            $login_candidate_id = Auth::guard('candidate')->id();
            $data = DB::table('teamup_request')
                    ->select('teamup_request.*', 'team_name.team_name as team_name', 'users.name as team_creator_name', 'team_name.team_creator as team_creator_id')
                    ->leftjoin("team_name", "team_name.id", "=", "teamup_request.team_id")
                    ->leftjoin("users", "users.id", "team_name.team_creator")
                    ->where("candidate_id", $login_candidate_id)
                    ->where("status", 2)
                    ->get()->toArray();
            
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('team_creator_name', function ($row) {
                $team_creator_name =  $row->team_creator_name;
                $team_creator_name =    "<a href=" . route('front_end-candidate_details_view', ['candidate_id' => $row->team_creator_id,'team_request' => 1,'teamID' => $row->team_id]) . ">$row->team_creator_name</a>";
                return $team_creator_name;
            })
            ->addColumn('created_at', function ($row) {
                $oldDate = $row->created_at;
                $newDate = date("F j, Y", strtotime($oldDate));
                return $newDate;
            })
            ->addColumn('action', function ($row) {
                $action =  '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Reject Team Request">
                <button class="resume" onclick="reject_team_request(' . $row->candidate_id . ',' . $row->team_id . ')"><i class="fa fa-window-close" aria-hidden="true"></i></button></span> &nbsp
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Accept Team Request">
                <button class="resume" onclick="accept_team_request(' . $row->candidate_id . ',' . $row->team_id . ')"><i class="fa fa-check-square" aria-hidden="true"></i></button></span>';
                return $action;
            })
            ->addColumn('message', function ($row) {
                $message =  '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="View Message">
                <button class="resume" onclick="team_request_message(' . $row->team_id . ')"><i class="fa fa-eye" aria-hidden="true"></i></button></span>';
                return $message;
            })
            ->rawColumns(['team_creator_name', 'action', 'created_at','message'])
            ->make(true);
        }
    }

    public function team_joined_list(Request $request)
    {
        if ($request->ajax()) {
            $login_candidate_id = Auth::guard('candidate')->id();
            $data = DB::table('teamup_request')
            ->select('teamup_request.*', 'team_name.team_name as team_name', 'users.name as team_creator_name', 'team_name.team_creator as team_creator_id')
            ->leftjoin("team_name", "team_name.id", "=", "teamup_request.team_id")
            ->leftjoin("users", "users.id", "team_name.team_creator")
            ->where("candidate_id", $login_candidate_id)
            ->where("status", 1)
            ->get()->toArray();
            // ->toSql();

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('team_creator_name', function ($row) {
                $team_creator_name =  $row->team_creator_name;
                $team_creator_name =    "<a href=" . route('front_end-candidate_details_view', ['candidate_id' => $row->team_creator_id]) . ">$row->team_creator_name</a>";
                return $team_creator_name;
            })
            ->addColumn('created_at', function ($row) {
                $oldDate = $row->created_at;
                $newDate = date("F j, Y", strtotime($oldDate));
                return $newDate;
            })
            ->addColumn('updated_at', function ($row) {
                $oldDate = $row->updated_at;
                $newDate = date("F j, Y", strtotime($oldDate));
                return $newDate;
            })
            ->addColumn('teamMembers', function ($row) {
                $teamMembers =  "<button  class='delete_job' data-toggle='tooltip' title='Teammates list' onclick='my_teammates_list(" . $row->team_id . ")'><i class='fa fa-users' style='color:#21254C' aria-hidden='true'></i></button>";
                return $teamMembers;
            })
            ->addColumn('leaveTeam', function ($row) {
                $leaveTeam =  "<button  class='delete_job' data-toggle='tooltip' title='Leave team' onclick='reject_team_request(" . $row->candidate_id . ',' . $row->team_id . ")'><i class='fa fa-trash' style='color:#21254C' aria-hidden='true'></i></button>";
                return $leaveTeam;
            })
            ->addColumn('viewtask', function ($row) {
                $viewtask =  "<button  class='delete_job' data-toggle='tooltip' title='View task' onclick='view_my_task(" . $row->candidate_id . ',' . $row->team_id . ")'><i class='fas fa-eye' style='color:#21254C'></i></button>";
                return $viewtask;
            })
            ->rawColumns(['team_creator_name', 'action', 'created_at', 'updated_at', 'leaveTeam','viewtask','teamMembers'])
            ->make(true);
        }
    }

    public function team_request_deny(Request $request)
    {
        Helper::isSubscribed();
        $candidate_id = $request->candidate_id;
        $team_id = $request->team_id;
        $result['status'] = 0;
        $result['msg'] = "Oops ! Team Request not reject !";
        if ($candidate_id != '' && $team_id != '') {
            $find_team_req = Teamuprequest::where('candidate_id', $candidate_id)->where('team_id', $team_id)->first();
            if ($find_team_req->status != 0) {
                $find_team_req->status = '0';
                $find_team_req->updated_at = Carbon::now();
                $find_team_req->save();
                $result['status'] = 1;
                $result['msg'] = "Team Invitation Reject Successfully";
            } else {
                $result['status'] = 0;
                $result['msg'] = "Oops ! Team Invitation Reject unSuccessfully !";
            }
        }
        echo json_encode($result);
        exit;
    }

    public function team_request_accept(Request $request)
    {
        Helper::isSubscribed();
        $candidate_id = $request->candidate_id;
        $team_id = $request->team_id;
        $result['status'] = 0;
        $result['msg'] = "Oops ! Team Request not Accept !";
        if ($candidate_id != '' && $team_id != '') {
            $find_team_req = Teamuprequest::where('candidate_id', $candidate_id)->where('team_id', $team_id)->first();
            if ($find_team_req->status != 1) {
                $find_team_req->status = '1';
                $find_team_req->updated_at = Carbon::now();
                $find_team_req->save();
                $result['status'] = 1;
                $result['msg'] = "Team Invitation Accept Successfully";
            } else {
                $result['status'] = 1;
                $result['msg'] = "Team Invitation Accept unSuccessfully.";
            }
        }
        echo json_encode($result);
        exit;
    }

    public function team_request_deny_mail($candidateId, $candidateTeamid)
    {
        Helper::isSubscribed();
        if ($candidateId != '' &&  $candidateTeamid != '') {
            $find_team_req = Teamuprequest::where('candidate_id', $candidateId)->where('team_id', $candidateTeamid)->first();
            if ($find_team_req->status == 2) {
                $find_team_req->status = '0';
                $find_team_req->updated_at = Carbon::now();
                $find_team_req->save();
                return redirect()->route('front_end-team_up_action')->with('success', 'Team Invitation rejected successfully');
            } else {
                return redirect()->route('front_end-team_up_action')->with('error', 'Oops ! Team Invitation rejected unsuccessfully or already rejected');
            }
        }
    }

    public function team_request_accept_mail($candidateId, $candidateTeamid)
    {
        Helper::isSubscribed();
        if ($candidateId != '' && $candidateTeamid != '') {
            $find_team_req = Teamuprequest::where('candidate_id', $candidateId)->where('team_id', $candidateTeamid)->first();
            if ($find_team_req->status == 2) {
                $find_team_req->status = '1';
                $find_team_req->updated_at = Carbon::now();
                $find_team_req->save();
                return redirect()->route('front_end-team_up_action')->with('success', 'Team Invitation Accept Successfully');
            } else {
                return redirect()->route('front_end-team_up_action')->with('error', 'Team Invitation Accept unSuccessfully or already in team.');
            }
        }
    }

    public function add_team_name(Request $request)
    {
        Helper::isSubscribed();
        $validation = Validator::make($request->all(), [
            'team_name'         => 'required|unique:team_name,team_name,' .$request->edit_team_id,
            'description'       => 'required',
            'attachments'       => 'mimes:pdf,doc,docx|max:2048',
        ]);
        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }
        $result['status'] = 0;
        $data = $request->all();
        if ($request->attachments != '' && $request->attachments != null) {
            $attachments = time() . '.' . $request->attachments->extension();
            $request->attachments->move(public_path('assets/front_end/Upload/team_attachments'), $attachments);
            if($request->edit_team_id != null && $request->edit_team_id != ''){
                $data_update = Teamname::where('id', $request->edit_team_id)->first();
                $unlinkAttachments = public_path('assets/front_end/Upload/team_attachments/'.$data_update->attachments);     
                if($data_update->attachments != '' && $data_update->attachments != null && file_exists($unlinkAttachments)){
                    unlink($unlinkAttachments);
                }   
            }
        }
        if ($request->edit_team_id == '' && $request->edit_team_id == null) {
            $data_insert = new Teamname;
            $data_insert->team_name       = $data['team_name'];
            $data_insert->description     = $data['description'];
            $data_insert->attachments     = isset($attachments) ? $attachments : null;
            $data_insert->team_creator    = Auth::guard('candidate')->id();
            $data_insert->created_at      = Carbon::now();
            $data_insert->save();
            $insert_id = $data_insert->id;
            if ($insert_id) {
                $result['status'] = 1;
                $result['msg'] = 'Team created successfully';
                $result['teamid'] = $insert_id;
            }
        } else {
            $data_update = Teamname::where('id', $request->edit_team_id)->first();
            $data_update->team_name     = $data['team_name'];
            $data_update->description   = $data['description'];
            $data_update->attachments   = isset($attachments) ? $attachments : $data_update->attachments;
            $data_update->updated_at    = Carbon::now();
            $data_update->save();
            $update_id = $data_update->id;
            if ($update_id) {
                $result['status'] = 1;
                $result['msg'] = 'Team Updated successfully';
                $result['teamid'] = $request->edit_team_id;
            }
        }
        echo json_encode($result);
        exit;
    }

    public function team_addmember(Request $request){
        
        // Helper::isSubscribed();
        // $result['status'] = 0;
        // $login_candidate   = Auth::guard('candidate')->user()->name;
        // $candidate = Userprofile::where('id', $request->Candidate_id)->first();

        // $candidateEmail = $candidate->email;
        // $candidateName  = $candidate->name;
        // $candidateId    = $candidate->id;
        // $template = Emailtemplate::where('template_name', 'teamup')->first();
        // $data = [
        //     'name'              => $candidateName,
        //     'subject'           => $template->subject,
        //     'description'       => $template->description,
        //     'email'             => $candidateEmail,
        //     'login_candidate'   => $login_candidate,
        //     'candidateId'       => $candidateId,
        //     'candidateTeamid'   => $request->Teamid
        // ];
        // Mail::send('Front_end/candidate/ManageProfile/teamup_template', ["data" => $data], function ($message) use ($data) {
        //     $message->to($data['email'])
        //     ->subject($data['subject']);
        // });
        // if (Mail::failures()) {
        //     $result['status'] = 0;
        // } else {
            $Teamuprequest_insert = new Teamuprequest;
            if (empty($request->edit_team_id)) {
                $Teamuprequest_insert->team_id       = $request->Teamid;
            } else {
                $Teamuprequest_insert->team_id       = $request->edit_team_id;
            }
            $Teamuprequest_insert->candidate_id  = $request->Candidate_id;
            $Teamuprequest_insert->status        = '2';
            $Teamuprequest_insert->description   = $request->descriptionData;
            $Teamuprequest_insert->created_at    = Carbon::now();
            $Teamuprequest_insert->save();
            $insert_id = $Teamuprequest_insert->id;
            if ($insert_id) {
                $result['status'] = 1;
            }
        // }
        echo json_encode($result);
        exit;
    }

    public function add_new_task(Request $request)
    {
        Helper::isSubscribed();
        $validation = Validator::make($request->all(), [
            'task_name'             => 'required|unique:team_tasks,task_name,' . $request->edit_task_id,
            'taskdescription'       => 'required',
            'taskattachments'       => 'mimes:pdf,doc,docx|max:2048',
        ]);
        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }
        $result['status'] = 0;
        $data = $request->all();

        if ($request->taskattachments != '' && $request->taskattachments != null) {
            $taskAttachments = time() . '.' . $request->taskattachments->extension();
            $request->taskattachments->move(public_path('assets/front_end/Upload/team_task_attachments'), $taskAttachments);
        }
        if($request->edit_task_id != null && $request->edit_task_id != ''){
            $data_update = Teamtask::where('id', $request->edit_task_id)->first();
            $unlinkAttachments = public_path('assets/front_end/Upload/team_task_attachments/'.$data_update->attachments);
            if($data_update->attachments != '' && $data_update->attachments != null && file_exists($unlinkAttachments)){
                unlink($unlinkAttachments);
            }
        }
        if ($request->edit_task_id == '' && $request->edit_task_id == null) {
            $data_insert = new Teamtask;
            $data_insert->team_id         = $data['task_team_id'];
            $data_insert->task_name       = $data['task_name'];
            $data_insert->description     = $data['taskdescription'];
            $data_insert->attachments     = isset($taskAttachments) ? $taskAttachments : '';
            $data_insert->created_at      = Carbon::now();
            $data_insert->save();
            $insert_id = $data_insert->id;
            if ($insert_id) {
                $result['status'] = 1;
                $result['msg'] = 'Team task created successfully';
                $result['teamid'] = $insert_id;
            }
        } else {
            $data_update = Teamtask::where('id', $request->edit_task_id)->first();
            // $data_update->team_id       = $data['task_team_id'];
            $data_update->task_name     = $data['task_name'];
            $data_update->description   = $data['taskdescription'];
            $data_update->attachments   = isset($taskAttachments) ? $taskAttachments : $data_update->attachments;
            $data_update->updated_at    = Carbon::now();
            $data_update->save();
            $update_id = $data_update->id;
            if ($update_id) {
                $result['status'] = 1;
                $result['msg'] = 'Team task Updated successfully';
                $result['teamid'] = $request->edit_task_id;
            }
        }
        echo json_encode($result);
        exit;
    }

    public function team_task_list_view($team_id)
    {
        Helper::isSubscribed();
        $team_id = $team_id;
        return view('Front_end/candidate/ManageProfile/team_task_list')->with(compact('team_id'));
    }

    public function team_task_list(Request $request)
    {
        Helper::isSubscribed();
        $attachments_url = $request->input('attachments_url');
        $team_id = $request->input('team_id');
        $taskData = DB::table('team_tasks')
        ->select('team_tasks.*', 'team_name.team_name as team_name', 'users.name as team_creator_name', 'team_name.team_creator as team_creator_id')
        ->leftjoin("team_name", "team_name.id", "=", "team_tasks.team_id")
        ->leftjoin("users", "users.id", "team_name.team_creator")
        ->where("team_name.id", $team_id);
        return Datatables::of($taskData)
        ->addIndexColumn()
        ->addColumn('team_creator_name', function ($row) {
            $team_creator_name =  $row->team_creator_name;
            $team_creator_name =  "<a href=" . route('front_end-candidate_details_view', ['candidate_id' => $row->team_creator_id]) . ">$row->team_creator_name</a>";
            return $team_creator_name;
        })
        ->addColumn('download', function ($row) use($attachments_url) {
            $download  = "<button class='edit_job'><a href=" . $attachments_url . $row->attachments . " target='_blank'><i style='color:#21254C'class='fa fa-download' aria-hidden='true'></i></a></button>";
            return $download;
        })
        ->addColumn('action', function ($row) {
            $action = "<button class='edit_job' onclick='task_edit(" . $row->id . ',' . $row->team_id . ")'><i class='fa fa-pencil-square' style='color:#21254C' aria-hidden='true'></i></button>";
            $action .=  "<button  class='delete_job' onclick='task_delete(" . $row->id . ',' . $row->team_id . ")'><i class='fa fa-trash' style='color:#21254C' aria-hidden='true'></i></button>";
            return $action;
        })
        ->rawColumns(['team_creator_name', 'action','download','created_at'])
        ->make(true);
    }

    public function task_delete(Request $request){
        Helper::isSubscribed();
        $team_id = $request->team_id;
        $task_id = $request->task_id;
        $result['status'] = 0;
        $result['msg'] = "Oops ! Team Not Delete !";
        if (!empty($team_id)) {
            $remove_sql = Teamtask::where('id', $task_id)->where('team_id',$team_id)->delete();
            if ($remove_sql) {
                $result['status'] = 1;
                $result['msg'] = "Team Delete Successfully";
            }
        }
        echo json_encode($result);
        exit;
    }

    public function task_edit(Request $request){
        Helper::isSubscribed();
        $team_id = $request->input('team_id');
        $task_id = $request->input('task_id');
        $responsearray = array();
        $responsearray['status'] = 0;
        if (!empty($team_id) && !empty($task_id)) {
            $edit_sql = Teamtask::where('id', $task_id)->where('team_id',$team_id)->first();
            
            if ($edit_sql) {
                $responsearray['status'] = 1;
                $responsearray['sqlData'] = $edit_sql;
            }
        }
        echo json_encode($responsearray);
        exit;
    }

    public function gave_task(Request $request){
        $team_id = $request->input('team_id');
        $candidate_id = $request->input('candidate_id');
        $getDatasql  = Teamtask::where('team_id',$team_id)->get()->toArray();
        
        $table = '<table class="table table-hover table-sm">
        <tr class="thead-dark">
        <th scope="col">Task Name</th>
        <th scope="col">Assign Task</th>
        </tr>';
        if(isset($getDatasql)){
            foreach ($getDatasql as $Datasql) {      
                $getTaskdata = Candidatetask::where('team_id',$Datasql['team_id'])->where('candidate_id',$candidate_id)->where('task_id',$Datasql['id'])->get()->toArray();
                $table .= '     <tr style="margin-left: 10px;">
                <td>' . $Datasql['task_name'] . '</td>';
                $isEmptyStyle = 'display:none';
                $alreadyAssigned = 'display:block';
                if(empty($getTaskdata)){
                    $isEmptyStyle = 'display:block';
                    $alreadyAssigned = 'display:none';
                }
                $table .= '     <td style="'.$isEmptyStyle.'" ><button class="delete_job" id="assignTask_'.$Datasql['id'].'" data-toggle="tooltip" title="Assign task" onclick="add_task_member(' . $candidate_id . ',' . $Datasql['id'] . ',' . $Datasql['team_id'] . ')"><i class="far fa-square"></i></button></td>';

                $table .= '      <td style="'.$alreadyAssigned.'" ><button class="delete_job" id="alreadyAssignTask_'.$Datasql['id'].'" data-toggle="tooltip" title="Already assign" onclick="add_task_member(' . $candidate_id . ',' . $Datasql['id'] . ',' . $Datasql['team_id'] . ')"><i class="fas fa-check-square"></i></button>
                <button class="delete_job" id="removeTask_'.$Datasql['id'].'" data-toggle="tooltip" title="Remove task"    onclick="remove_task_member(' . $candidate_id . ',' . $Datasql['id'] . ',' . $Datasql['team_id'] . ')"><i class="fa fa-window-close" aria-hidden="true"></i></button>
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

        echo json_encode($responsearray);
        exit;
    }

    public function candidate_task(Request $request)
    {
        $team_id = $request->input('team_id');
        $candidate_id = $request->input('candidate_id');
        $attachments_url = $request->input('attachments_url');
        $getDatasql  = DB::table('candidate_task')
        ->select('team_tasks.*', 'team_tasks.task_name as task_name', 'team_tasks.attachments as attachments', 'team_tasks.description as description')
        ->leftjoin("team_tasks", "team_tasks.id", "=", "candidate_task.task_id")
        ->where("candidate_task.team_id",$team_id)
        ->where("candidate_task.candidate_id",$candidate_id)
        ->get()->toArray();

        $table = '<table class="table table-hover table-sm">
        <tr class="thead-dark">
        <th scope="col">Task Name </th>
        <th scope="col">Task Assign Date</th>
        <th scope="col">View attachments</th>
        </tr>';
        if(isset($getDatasql)){
            foreach ($getDatasql as $Datasql) {
                $newDate = date("F j, Y", strtotime($Datasql->created_at));  
                $table .= '     <tr style="margin-left: 10px;">
                <td>' . $Datasql->task_name . '</td>
                <td>' . $newDate . '</td>
                <td><button class="edit_job"><a href=' . $attachments_url . $Datasql->attachments . ' target="_blank"><i style="color:#21254C" class="fas fa-eye" aria-hidden="true"></i></a></button>';
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

        echo json_encode($responsearray);
        exit;

    }

    public function task_add_candidate(Request $request){
        Helper::isSubscribed();
        $candidate_id = $request->candidate_id;
        $team_id = $request->team_id;
        $task_id = $request->task_id;
        $result['status'] = 0;
        $result['msg'] = "Oops ! Task assign unSuccessfully!";
        if ($candidate_id != '' && $team_id != '') {
            $Candidatetask = new Candidatetask;
            $taskAssignorNot = Candidatetask::where('team_id',$team_id)->where('task_id',$task_id)->where('candidate_id',$candidate_id)->get()->toArray();
            if(empty($taskAssignorNot)){
                $Candidatetask->team_id = $team_id;
                $Candidatetask->task_id = $task_id;
                $Candidatetask->candidate_id = $candidate_id;
                $Candidatetask->created_at = Carbon::now();
                $Candidatetask->save();
                $result['status'] = 1;
                $result['msg'] = "Task assign successfully";
            } else {
                $result['status'] = 0;
                $result['msg'] = "Already Task assigned.";
            }   
        }
        echo json_encode($result);
        exit;
    }

    public function task_remove_candidate(Request $request){
        Helper::isSubscribed();
        $candidate_id = $request->candidate_id;
        $team_id = $request->team_id;
        $task_id = $request->task_id;
        $result['status'] = 0;
        $result['msg'] = "Oops ! Task Remove unSuccessfully!";
        if ($candidate_id != '' && $team_id != '' && $task_id != '') {
            $removeCandidatetask = Candidatetask::where('team_id',$team_id)->where('task_id',$task_id)->where('candidate_id',$candidate_id)->delete();
            if($removeCandidatetask){
                $result['status'] = 1;
                $result['msg'] = "Task Remove successfully";
            } else {
                $result['status'] = 0;
                $result['msg'] = "Already Task Removeed.";
            }   
        }
        echo json_encode($result);
        exit;
    }


    public function my_teammates_list(Request $request){
        $team_id = $request->team_id;
        $getDatasql  = DB::table('teamup_request')
        ->select('teamup_request.*', 'team_name.team_name as team_name', 'users.name as candidate_name')
        ->leftjoin("team_name", "team_name.id", "=", "teamup_request.team_id")
        ->leftjoin("users", "users.id", "teamup_request.candidate_id")
        ->where("team_id", $team_id)
        ->get()->toArray();

        $table = '<table class="table table-hover table-sm">
        <tr class="thead-dark">
        <th scope="col">Team Name </th>
        <th scope="col">Team Member Name</th>
        <th scope="col">Status</th>
        </tr>';
        $sql_count = $getDatasql->count();
        
        if(($sql_count > 0)){
            foreach ($getDatasql as $Datasql) {
                if ($Datasql->status == 1) {
                    $status = '<nobr><span class="full-time">Request Accept</span></nobr>';
                } else if ($Datasql->status == 0) {
                    $status = '<nobr><span class="part-time">request Deny</span></nobr>';
                } else if ($Datasql->status == 2) {
                    $status = '<nobr><span class="freelance">Requested</span></nobr>';
                }
                $table .= '     <tr style="margin-left: 10px;">
                <td>' . $Datasql->team_name . '</td>
                <td>' . $Datasql->candidate_name . '</td>
                <td>' . $status . '</td>';
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

        echo json_encode($responsearray);
        exit;
    }
}

