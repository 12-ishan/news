<?php

namespace App\Http\Controllers\admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response;
use App\Models\Admin\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(){

        if (Auth::user()) {   // Check is user logged in

            return redirect()->intended('/dashboard');
            
        }

        $data["pageTitle"] = 'Login';
        return view('admin.login')->with($data);

    }

    public function doLogin(Request $request){
     
        $this->validate(request(), [
            'email' => 'required',
            'password' => 'required',
            ]);
     
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {

                $user = Auth::user();
               // if ($user->roleId === 1 || $user->roleId === 2) {
               if ($user){
                    return redirect()->intended('/dashboard');
                    
                }else{

                    Auth::logout(); 
                    return redirect()->route('adminLogin')->with('message', 'Invalid Access');
                    
                }

                // Authentication passed...
                
            }
            return Redirect::to("/login")->with('message', 'Oppes! You have entered invalid credentials');
    }


    public function register(){
        $data["pageTitle"] = 'Register';
        return view('admin.register')->with($data);

    }

    public function createUser(Request $request)
    {

        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ]);
        
 

        $user = new User();

        $password = $request->input('password');

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($password);
        $user->status = 1;
        $user->sortOrder = 1;
        $user->increment('sortOrder');

        $user->save();
    
        
        return redirect()->to('/login')->with('message', 'Congratulations! Registration Successfull');;
    }

    public function logout(){
     
        Auth::logout(); 
        return Redirect::to('/login')->with('message', 'Logged Out Successfully');; 

    }


}
