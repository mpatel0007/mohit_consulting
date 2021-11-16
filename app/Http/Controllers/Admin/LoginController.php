<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
// use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function adminloginview()
    {
        $user = Auth::guard('admin')->user(); 
        if(Auth::guard('admin')->check()){
            if($user->is_admin == 1){
                return redirect( ADMIN.'/dashboard');
            }
        }
        return view('Admin/layouts/login/adminlogin');
    }
    public function adminloginproccess(Request $request) {  
        $user = Auth::guard('admin')->user();
        if(Auth::guard('admin')->check()){
            if($user->is_admin == 1){
                return redirect( ADMIN.'/dashboard');
            }
        }else{
            $this->validate($request, [
                'email'   => 'required|email',
                'password' => 'required|min:6'
            ]);
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password ,'is_admin' => '1','status' => '1'])){
                return redirect()->intended(ADMIN.'/dashboard');
            } else {
                return redirect()->back()->with('error', 'Admin does not exist !');
            }
        }
        
        
        // $user = auth()->user();
        // if (Auth::check()) {
        //     if($user->is_admin == 1){
        //         return redirect( ADMIN.'/dashboard');
        //     }
        // }
    	// return view('Admin/layouts/login/adminlogin');
    }

    public function register() {  
        $user = auth()->user();
        if (Auth::check()) {
            if($user->is_admin == 1){
                return redirect( ADMIN.'/dashboard');
            }
        }
    	return view('Admin/layouts/login/register');
    }

    public function logout(Request $request) {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect(ADMIN.'/login');
    }
}
