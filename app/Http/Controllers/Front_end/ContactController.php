<?php

namespace App\Http\Controllers\Front_end;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Emailtemplate;
use Illuminate\Support\Facades\Auth;
use Mail;

class ContactController extends Controller
{
    public function index()
    {
        $setting = Setting::select()->first();
        return view('Front_end/pages/contact')->with(compact('setting'));
    }
    function sendcontact(Request $request){
        $validation = Validator::make($request->all(), [
            'name'        => 'required',
            'email'       => 'required',
            'msg_subject' => 'required',
            'message'     => 'required',
        ]);
        if ($validation->fails()) {
            $result['status'] = 0;
            $result['error'] = $validation->errors()->all();
            echo json_encode($result);
            exit();
        }
        $result['status'] = 0;
        $result['msg'] = "Oops ! not Sent";
        $data = $request->input();
        $contact = new Contact();
        $contact->name = $data['name'];
        $contact->email = $data['email'];
        $contact->msg_subject = $data['msg_subject'];
        $contact->message = $data['message'];
        $contact->save();
        $template = Emailtemplate::where('template_name','contactus')->first();
        $data = [
            'subject'     => $template->subject,
            'description' => $template->description,
            'name'        => $data['name'],
            'email'       => $data['email'],
            'msg_subject' => $data['msg_subject'],
            'message'     => $data['message']
        ];
        Mail::send('Front_end.pages.contact-template',["userdata"=>$data] , function($message) use ($data) {
            $message->to($data['email'])
            ->subject($data['subject']);
        });
        $insert_id = $contact->id;
        if($insert_id){
          $result['status'] = 1;
          $result['msg'] = "Message sent Successfully";
          $result['id'] = $insert_id;
      }
      echo json_encode($result);
      exit();

  }
}