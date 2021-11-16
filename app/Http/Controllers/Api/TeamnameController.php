<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Models\Teamname;
use App\Models\Teamuprequest;
use App\Models\Teamtask;
use App\Models\Userprofileskilllevel;
use App\Models\Candidatetask;
use App\Candidate;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
// use Carbon\Candidatetask;

class TeamnameController extends APIController
{
    public function list(){
        if (Auth::check()) {
            $Teamname = Teamname::where('team_creator',Auth::user()->id)->get();
            $teamname_temp = array();
            if(!empty($Teamname)){
                
                foreach($Teamname as $Team){
                    $demo_array = array();
                    $data = DB::table('teamup_request')
                        ->select('teamup_request.*','team_name.team_name as team_name','users.profileimg','users.name as candidate_name',DB::raw('group_concat(jobskill.jobskill) as jobskill'))
                        ->leftjoin("team_name", "team_name.id", "=", "teamup_request.team_id")
                        ->leftjoin("users","users.id","teamup_request.candidate_id")
                        ->leftjoin('userprofile_skilllevel','userprofile_skilllevel.userprofile_id','teamup_request.candidate_id')
                        ->leftjoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                        ->groupBy('teamup_request.id')
                        ->where("teamup_request.team_id",$Team->id)
                        ->get();
                        $team_member_temp_array = array();
                        foreach($data as $member){
                            $candidate = Candidatetask::select('task_id')->where(['team_id'=>$member->team_id,'candidate_id'=>$member->candidate_id])->get()->toArray();
                            $candidate_task_list = array();
                            if(!empty($candidate)){
                                
                                foreach($candidate as $candidate_task){
                                    $candidate_task_list[] = $candidate_task['task_id'];
                                }
                            }
                            
                            $team_member = array();
                            $team_member = $member;     
                            //$candidate = Candidatetask::select('task_id')->where(['team_id'=>$member->team_id,'candidate_id'=>$member->candidate_id])->get();
                            
                            $team_member->candidatetask = $candidate_task_list;
                            $team_member_temp_array[] = $team_member;
                        }
                    $task = DB::table('team_tasks')
                        ->select('team_tasks.*', 'team_name.team_name as team_name', 'users.name as team_creator_name', 'team_name.team_creator as team_creator_id')
                        ->leftjoin("team_name", "team_name.id", "=", "team_tasks.team_id")
                        ->leftjoin("users", "users.id", "team_name.team_creator")
                        ->where("team_name.id", $Team->id)
                        ->get();
                        
                        if(!empty($task)){
                            foreach($task as $task_key=>$task_value){
                                if($task[$task_key]->attachments != null && $task[$task_key]->attachments != ''){
                                    $task[$task_key]->attachments = url('/assets/front_end/Upload/team_task_attachments/'.$task[$task_key]->attachments);
                                }
                            }
                            
                        }
                        
                        
                        $demo_array = $Team;
                        $demo_array['team_member'] = $team_member_temp_array;
                        $demo_array['team_task_list'] = $task;
                        // $demo_array['team_member']->skills = $userSkill;
                        $teamname_temp[] = $demo_array;
                }   
            }
            $json['data'] = $teamname_temp;
            return $this->respond($json);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
    public function member_list($team_id){
        if($team_id > 0){
            if (Auth::check()) {
                $data = DB::table('teamup_request')
                        ->select('teamup_request.*','team_name.team_name as team_name','users.name as candidate_name')
                        ->leftjoin("team_name", "team_name.id", "=", "teamup_request.team_id")
                        ->leftjoin("users","users.id","teamup_request.candidate_id")
                        ->where("team_id",$team_id)
                        ->get();
                
                $json['data'] = $data;
                return $this->respond($json);
            }else{
                return $this->noRespondWithMessage('Login Fail, Please Login Again.');
            }
        }else{
            return $this->noRespondWithMessage('Team id not found.');
        }
        
        
    }
    public function teamrequest_list(){
        if (Auth::check()) {
            $Teamuprequest = Teamuprequest::select('teamup_request.*','team_name.team_name as team_name', 'users.name as team_creator_name','team_name.team_creator as team_creator_id')
            ->leftjoin("team_name", "team_name.id", "teamup_request.team_id")
            ->leftjoin("users","users.id","team_name.team_creator")
            ->where("candidate_id",Auth::user()->id)  
            ->where("status",2)
            ->get();
            $teamname_temp = array();
            if(!empty($Teamuprequest)){
                
                foreach($Teamuprequest as $Team){
                    $demo_array = array();
                    $data = DB::table('teamup_request')
                        ->select('teamup_request.*','team_name.team_name as team_name','users.profileimg','users.name as candidate_name',DB::raw('group_concat(jobskill.jobskill) as jobskill'))
                        ->leftjoin("team_name", "team_name.id", "=", "teamup_request.team_id")
                        ->leftjoin("users","users.id","teamup_request.candidate_id")
                        ->leftjoin('userprofile_skilllevel','userprofile_skilllevel.userprofile_id','teamup_request.candidate_id')
                        ->leftjoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                        ->groupBy('teamup_request.id')
                        ->where("teamup_request.team_id",$Team->id)
                        ->get();
                        
                        $demo_array = $Team;
                        $demo_array['team_member'] = $data;
                        $teamname_temp[] = $demo_array;
                }
                
            }
            $json['data'] = $teamname_temp;
            return $this->respond($json);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
    public function teamrequest_change(Request $request){
        $validation = Validator::make($request->all(), [
            'request_id'=>'required',
            'status'=>'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            $Teamuprequest_found = Teamuprequest::where(['id'=>$request->request_id,'candidate_id'=>Auth::user()->id])->first();
            if(!empty($Teamuprequest_found)){
                $Teamuprequest_found->status = $request->status;
                $Teamuprequest_found->updated_at = Carbon::now();
                $Teamuprequest_found->save();
                $Teamuprequest = Teamuprequest::select('teamup_request.*','team_name.team_name as team_name', 'users.name as team_creator_name','team_name.team_creator as team_creator_id')
                    ->leftjoin("team_name", "team_name.id", "teamup_request.team_id")
                    ->leftjoin("users","users.id","team_name.team_creator")
                    ->where("candidate_id",Auth::user()->id)  
                    ->where("status",2)
                    ->get();
                    if(!empty($Teamuprequest)){
                        $teamname_temp = array();
                        foreach($Teamuprequest as $Team){
                            $demo_array = array();
                            $data = DB::table('teamup_request')
                                ->select('teamup_request.*','team_name.team_name as team_name','users.profileimg','users.name as candidate_name',DB::raw('group_concat(jobskill.jobskill) as jobskill'))
                                ->leftjoin("team_name", "team_name.id", "=", "teamup_request.team_id")
                                ->leftjoin("users","users.id","teamup_request.candidate_id")
                                ->leftjoin('userprofile_skilllevel','userprofile_skilllevel.userprofile_id','teamup_request.candidate_id')
                                ->leftjoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                                ->groupBy('teamup_request.id')
                                ->where("teamup_request.team_id",$Team->id)
                                
                                ->get();
                                
                                $demo_array = $Team;
                                $demo_array['team_member'] = $data;
                                $teamname_temp[] = $demo_array;
                        }
                        
                    }else{
                        $teamname_temp = array();
                    }
            }else{
                return $this->noRespondWithMessage('Team Request not found for you.!');    
            }
            
            $json['data'] = $teamname_temp;
            return $this->respond($json);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
    public function teamrequest_remove(Request $request){
        $validation = Validator::make($request->all(), [
            'request_id'=>'required',
            
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            $Teamuprequest_found = Teamuprequest::where(['id'=>$request->request_id])->first();
            if($Teamuprequest_found){
                $Teamuprequest_found->delete();

                $Teamname = Teamname::where('team_creator',Auth::user()->id)->get();
                $teamname_temp = array();
                if(!empty($Teamname)){
                    
                    foreach($Teamname as $Team){
                        $demo_array = array();
                        $data = DB::table('teamup_request')
                            ->select('teamup_request.*','team_name.team_name as team_name','users.profileimg','users.name as candidate_name',DB::raw('group_concat(jobskill.jobskill) as jobskill'))
                            ->leftjoin("team_name", "team_name.id", "=", "teamup_request.team_id")
                            ->leftjoin("users","users.id","teamup_request.candidate_id")
                            ->leftjoin('userprofile_skilllevel','userprofile_skilllevel.userprofile_id','teamup_request.candidate_id')
                            ->leftjoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                            ->groupBy('teamup_request.id')
                            ->where("teamup_request.team_id",$Team->id)
                            ->get();
                            $team_member_temp_array = array();
                            foreach($data as $member){
                                $candidate = Candidatetask::select('task_id')->where(['team_id'=>$member->team_id,'candidate_id'=>$member->candidate_id])->get()->toArray();
                                $candidate_task_list = array();
                                if(!empty($candidate)){
                                    
                                    foreach($candidate as $candidate_task){
                                        $candidate_task_list[] = $candidate_task['task_id'];
                                    }
                                }
                                
                                $team_member = array();
                                $team_member = $member;     
                                //$candidate = Candidatetask::select('task_id')->where(['team_id'=>$member->team_id,'candidate_id'=>$member->candidate_id])->get();
                                
                                $team_member->candidatetask = $candidate_task_list;
                                $team_member_temp_array[] = $team_member;
                            }
                        $task = DB::table('team_tasks')
                            ->select('team_tasks.*', 'team_name.team_name as team_name', 'users.name as team_creator_name', 'team_name.team_creator as team_creator_id')
                            ->leftjoin("team_name", "team_name.id", "=", "team_tasks.team_id")
                            ->leftjoin("users", "users.id", "team_name.team_creator")
                            ->where("team_name.id", $Team->id)
                            ->get();
                            if(!empty($task)){
                                foreach($task as $task_key=>$task_value){
                                    if($task[$task_key]->attachments != null && $task[$task_key]->attachments != ''){
                                        $task[$task_key]->attachments = url('/assets/front_end/Upload/team_task_attachments/'.$task[$task_key]->attachments);
                                    }
                                }
                                
                            }
                            // $userSkill = Userprofileskilllevel::select('userprofile_skilllevel.*','careerlevel.careerlevel','jobskill.jobskill')
                            //     ->join('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                            //     ->join('careerlevel','careerlevel.id','userprofile_skilllevel.level_id')
                            //     ->where('userprofile_skilllevel.userprofile_id',$data->candidate_id)->get();
                            $demo_array = $Team;
                            $demo_array['team_member'] = $data;
                            $demo_array['team_task_list'] = $task;
                            // $demo_array['team_member']->skills = $userSkill;
                            $teamname_temp[] = $demo_array;
                    }   
                }
                $json['data'] = $teamname_temp;
                return $this->respond($json);
            }else{
                return $this->noRespondWithMessage('Team Request Not Found.');    
            }
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
    public function teamjoined_list(){
        if (Auth::check()) {
            $Teamuprequest = Teamuprequest::select('teamup_request.*','team_name.team_name as team_name', 'users.name as team_creator_name','team_name.team_creator as team_creator_id')
            ->leftjoin("team_name", "team_name.id", "teamup_request.team_id")
            ->leftjoin("users","users.id","team_name.team_creator")
            ->where("candidate_id",Auth::user()->id)  
            ->where("status",1)
            ->get();
            $teamname_temp = array();
            if(!empty($Teamuprequest)){
                
                foreach($Teamuprequest as $Team){
                    $demo_array = array();
                    $data = DB::table('teamup_request')
                        ->select('teamup_request.*','team_name.team_name as team_name','users.profileimg','users.name as candidate_name',DB::raw('group_concat(jobskill.jobskill) as jobskill'))
                        ->leftjoin("team_name", "team_name.id", "=", "teamup_request.team_id")
                        ->leftjoin("users","users.id","teamup_request.candidate_id")
                        ->leftjoin('userprofile_skilllevel','userprofile_skilllevel.userprofile_id','teamup_request.candidate_id')
                        ->leftjoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                        ->groupBy('teamup_request.id')
                        ->where("teamup_request.team_id",$Team->id)
                        
                        ->get();
                        
                        $demo_array = $Team;
                        $demo_array['team_member'] = $data;
                        $teamname_temp[] = $demo_array;
                }
                
            }
            $json['data'] = $teamname_temp;
            //$json['data'] = $Teamuprequest;
            return $this->respond($json);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }

    public function get_users_list(Request $request){
        if (Auth::check()) {
            $Candidate = Candidate::select('users.*',DB::raw('group_concat(jobskill.jobskill) as jobskill'))
                        ->leftjoin('userprofile_skilllevel','userprofile_skilllevel.userprofile_id','users.id')
                        ->leftjoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
            ->where('users.id','!=',Auth::user()->id);
            $Candidate->groupBy('users.id');
            $Candidate = $Candidate->paginate(50);


            return $this->respond($Candidate);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
    public function create(Request $request){
        $validation = Validator::make($request->all(), [
            'team_name'     => 'required',
            'description'     => 'required',
            //'team_attachment'     => 'required',
            
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            $team_attachment_name = '';
            if(!empty($request->file('team_attachment'))){
                $extension = $request->file('team_attachment')->getClientOriginalExtension();
                $team_attachment_name = time().'.'.$extension;  
                $request->file('team_attachment')->move(public_path('assets/front_end/Upload/team_attachments'), $team_attachment_name);

            }
            
            // $request->attachments->move(public_path('assets/front_end/Upload/team_attachments'), $attachments);
            // if($request->edit_team_id != null && $request->edit_team_id != ''){
            //     $data_update = Teamname::where('id', $request->edit_team_id)->first();
            //     $unlinkAttachments = public_path('assets/front_end/Upload/team_attachments/'.$data_update->attachments);     
            //     if($data_update->attachments != '' && $data_update->attachments != null && file_exists($unlinkAttachments)){
            //         unlink($unlinkAttachments);
            //     }   
            // }

            if($request->team_id > 0){
                $Teamname = Teamname::where('id',$request->team_id)->first();
                $Teamname->team_name = $request->team_name;
                $Teamname->description = $request->description;
                if($team_attachment_name != ''){
                    $Teamname->attachments = $team_attachment_name;
                }
                $Teamname->created_at = Carbon::now();
                $Teamname->updated_at = Carbon::now();
                $Teamname->team_creator = Auth::user()->id;
                $Teamname->save();
            }else{
                $Teamname = new Teamname();
                $Teamname->team_name = $request->team_name;
                $Teamname->description = $request->description;
                $Teamname->attachments = $team_attachment_name;
                $Teamname->created_at = Carbon::now();
                $Teamname->updated_at = Carbon::now();
                $Teamname->team_creator = Auth::user()->id;
                $Teamname->save();
            }
            $json = array();
            if($request->team_id > 0){    
            
            $Candidate = Candidate::select('users.*',DB::raw('group_concat(jobskill.jobskill) as jobskill'),'teamup_request.status as teamup_request_status')
                        ->leftjoin('userprofile_skilllevel','userprofile_skilllevel.userprofile_id','users.id')
                        ->leftjoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                        ->where('users.id','!=',Auth::user()->id);
        
            $Candidate->leftjoin('teamup_request', function($join)use($request){
                $join->on('users.id','=', "teamup_request.candidate_id");
                $join->where("teamup_request.team_id" , $request->team_id);
            });
        
            $Candidate->groupBy('users.id');
            $Candidate = $Candidate->paginate(50);
            $json['teamname'] = $Teamname;
            $json['candidate'] = $Candidate;
        }else{
            $Candidate = Candidate::select('users.*',DB::raw('group_concat(jobskill.jobskill) as jobskill'))
                        ->leftjoin('userprofile_skilllevel','userprofile_skilllevel.userprofile_id','users.id')
                        ->leftjoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                        ->where('users.id','!=',Auth::user()->id);
        
            
            $Candidate->groupBy('users.id');
            $Candidate = $Candidate->paginate(50);
            $json['teamname'] = $Teamname;
            $json['candidate'] = $Candidate;
        }
            return $this->respond($json);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
    public function create_request(Request $request){
        $validation = Validator::make($request->all(), [
            'candidate_id'     => 'required',
            'team_id'     => 'required',
            
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            $Teamuprequest = new Teamuprequest();
            $Teamuprequest->team_id = $request->team_id;
            $Teamuprequest->candidate_id = $request->candidate_id;
            $Teamuprequest->status = 2;
            $Teamuprequest->created_at = Carbon::now();
            $Teamuprequest->updated_at = Carbon::now();
            $Teamuprequest->save();
            
            $Candidate = Candidate::select('users.*',DB::raw('group_concat(jobskill.jobskill) as jobskill'),'teamup_request.status as teamup_request_status')
                        ->leftjoin('userprofile_skilllevel','userprofile_skilllevel.userprofile_id','users.id')
                        ->leftjoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                        ->where('users.id','!=',Auth::user()->id);
            $Candidate->leftjoin('teamup_request', function($join)use($request){
                $join->on('users.id','=', "teamup_request.candidate_id");
                $join->where("teamup_request.team_id" , $request->team_id);
            });
            $Candidate->groupBy('users.id');
            $Candidate = $Candidate->paginate(50);
            
            $json['candidate'] = $Candidate;

            return $this->respond($json);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }
    public function edit_team_name(Request $request){
        $validation = Validator::make($request->all(), [
            'team_name_id'     => 'required',
            
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            $Teamname = Teamname::where('id',$request->team_name_id)->first();
            if($Teamname->team_creator != Auth::user()->id){
                return $this->noRespondWithMessage('You are not allow to edit.!');
            }
            $Candidate = Candidate::select('users.*',DB::raw('group_concat(jobskill.jobskill) as jobskill'),'teamup_request.status as teamup_request_status')
                        ->leftjoin('userprofile_skilllevel','userprofile_skilllevel.userprofile_id','users.id')
                        ->leftjoin('jobskill','jobskill.id','userprofile_skilllevel.skill_id')
                        ->where('users.id','!=',Auth::user()->id);
            $Candidate->leftjoin('teamup_request', function($join)use($request){
                $join->on('users.id','=', "teamup_request.candidate_id");
                $join->where("teamup_request.team_id" , $request->team_name_id);
            });
            $Candidate->groupBy('users.id');
            $Candidate = $Candidate->paginate(50);
            $json['teamname'] = $Teamname;
            $json['candidate'] = $Candidate;

            return $this->respond($json);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }

    public function create_team_task(Request $request){
        $validation = Validator::make($request->all(), [
            'task_name'             => 'required',
            'task_description'       => 'required',
            //'taskattachments'       => 'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            $taskAttachments = '';
            if(!empty($request->file('taskattachments'))){
                $extension = $request->file('taskattachments')->getClientOriginalExtension();
                $taskAttachments = time().'.'.$extension;  
                $request->file('taskattachments')->move(public_path('assets/front_end/Upload/team_task_attachments'), $taskAttachments);

            }
            
            
            $Teamtask = new Teamtask;
            $Teamtask->team_id         = $request->teamup_id;
            $Teamtask->task_name       = $request->task_name;
            $Teamtask->description     = $request->task_description;
            $Teamtask->attachments     = $taskAttachments;
            $Teamtask->created_at      = Carbon::now();
            $Teamtask->save();
            
            $task = DB::table('team_tasks')
                        ->select('team_tasks.*', 'team_name.team_name as team_name', 'users.name as team_creator_name', 'team_name.team_creator as team_creator_id')
                        ->leftjoin("team_name", "team_name.id", "=", "team_tasks.team_id")
                        ->leftjoin("users", "users.id", "team_name.team_creator")
                        ->where("team_name.id", $request->teamup_id)
                        ->get();
                        foreach ($task as $value) {
                            if($value->attachments != null && $value->attachments != ''){
                                $value->attachments = url('/assets/front_end/Upload/team_task_attachments/'.$value->attachments);
                            }
                        }
            
            $json['created_task'] = $task;
            $json['msg'] = "Task Created Successfully.!";

            return $this->respond($json);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }

    public function edit_team_task(Request $request){
        if (Auth::check()) {
            $team_id = $request->team_id;
            $task_id = $request->task_id;
            
            if (!empty($team_id) && !empty($task_id)) {
                $Teamtask = Teamtask::where('id', $task_id)->where('team_id',$team_id)->first();
            } else {
                return $this->noRespondWithMessage('Error !! Record not found !');
            }
            if($Teamtask->attachments != null && $Teamtask->attachments != ''){
                $Teamtask->attachments = url('/assets/front_end/Upload/team_task_attachments/'.$Teamtask->attachments);
            }
           
            $json['edit_task_data'] = $Teamtask;

            return $this->respond($json);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }       
    }

    public function team_task_update(Request $request){
        $validation = Validator::make($request->all(), [
            'task_name'             => 'required',
            'task_description'       => 'required',
            'taskattachments'       => 'mimes:pdf,doc,docx|max:2048',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            
            if(!empty($request->file('taskattachments'))){
                $extension = $request->file('taskattachments')->getClientOriginalExtension();
                $taskAttachments = time().'.'.$extension;  
                $request->file('taskattachments')->move(public_path('assets/front_end/Upload/team_task_attachments'), $taskAttachments);

            }
            
            $data_update = Teamtask::where('id', $request->task_id)->first();
            $data_update->task_name     = $request->task_name;
            $data_update->description   = $request->task_description;
            $data_update->attachments   = isset($taskAttachments) ? $taskAttachments : $data_update->attachments;
            $data_update->updated_at    = Carbon::now();
            $data_update->save();
            
            $task = DB::table('team_tasks')
                        ->select('team_tasks.*', 'team_name.team_name as team_name', 'users.name as team_creator_name', 'team_name.team_creator as team_creator_id')
                        ->leftjoin("team_name", "team_name.id", "=", "team_tasks.team_id")
                        ->leftjoin("users", "users.id", "team_name.team_creator")
                        ->where("team_name.id", $request->teamup_id)
                        ->first();
            if($task->attachments != null && $task->attachments){
                $task->attachments = url('/assets/front_end/Upload/team_task_attachments/'.$task->attachments);
            }
            $json['created_task'] = $task;
            $json['msg'] = "Task Update Successfully.!";
            return $this->respond($json);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }

    public function assign_task(Request $request){
        $validation = Validator::make($request->all(), [
            'candidate_id'  => 'required',
            'team_id'       => 'required',
            //'task_id'       => 'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
            $taskAssignorNot = Candidatetask::where('team_id',$request->team_id)->where('candidate_id',$request->candidate_id)->delete();
            
            if(!empty($request->task_id)){
                foreach($request->task_id as $task_id){
                    $Candidatetask = new Candidatetask;
                    $Candidatetask->team_id = $request->team_id;
                    $Candidatetask->task_id = $task_id;
                    $Candidatetask->candidate_id = $request->candidate_id;
                    $Candidatetask->created_at = Carbon::now();
                    $Candidatetask->save();
                }
            }
            $json['message'] = 'Task assign successfully';
            return $this->respond($json);
            // if(empty($taskAssignorNot)){
            //     $Candidatetask->team_id = $request->team_id;
            //     $Candidatetask->task_id = $request->task_id;
            //     $Candidatetask->candidate_id = $request->candidate_id;
            //     $Candidatetask->created_at = Carbon::now();
            //     $Candidatetask->save();
            //     return $this->noRespondWithMessage('Task assign successfully');
                
            // } else {
            //     return $this->noRespondWithMessage('Already Task assigned.');
                
            // }   
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }

    public function remove_assign_task(Request $request){
        $validation = Validator::make($request->all(), [
            'candidate_task_id'  => 'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
        
            $removeCandidatetask = Candidatetask::where('id',$request->candidate_task_id)->delete();
            if($removeCandidatetask){
                return $this->noRespondWithMessage('Task Remove successfully.');
            } else {
                return $this->noRespondWithMessage('Task Not Found.');
            }   
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }

    public function members_task_list(Request $request){
        $validation = Validator::make($request->all(), [
            'candidate_id'  => 'required',
            'team_id'  => 'required',
            
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->errors()->first());
        }
        if (Auth::check()) {
           
            $taskDatasql  = DB::table('candidate_task')
                        ->select('team_tasks.*', 'team_tasks.task_name as task_name', 'team_tasks.attachments as attachments', 'team_tasks.description as description')
                        ->leftjoin("team_tasks", "team_tasks.id", "=", "candidate_task.task_id")
                        ->where("candidate_task.team_id",$request->team_id)
                        ->where("candidate_task.candidate_id",$request->candidate_id)
                        ->get();
            $json['data'] = $taskDatasql;
            return $this->respond($json);
        }else{
            return $this->noRespondWithMessage('Login Fail, Please Login Again.');
        }
    }

}
