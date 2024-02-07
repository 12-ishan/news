<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Frontend\LoginOtpVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;


class StudentController extends Controller
{
    //
    public function studentRegister(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:student,email',
            'password' => 'required|min:8',
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => 'Validation failed', 'errors' => $errors], 422);
        }
    
        // Proceed with registration if validation passes
        $checkStudent = Student::where('email', $request->email)->first();
    
        if (empty($checkStudent))
         {
            $student = new Student();
    
            $password = $request->input('password');
    
            $student->first_name = $request->input('first_name');
            $student->last_name = $request->input('last_name');
            $student->email = $request->input('email');
            $student->password = Hash::make($password);
            $student->receive_updates = $request->input('receive_updates');
            $student->is_otp_verified = 0;
            $student->otp = generateRandomOtp(6);
            $student->status = 1;
            $student->sort_order = 1;
            $student->increment('sort_order');
            $student->save();
    
            $token = $student->createToken($request->email)->plainTextToken;
    
            $response = [
                'message' => 'Registered successfully',
                'status' => 'success',
                'student' => $student->id,
                'token' => $token
            ];
        } else {
            $response = [
                'message' => 'Email already exists',
                'status' => 'failed'
            ];
        }
    
        return response()->json($response, 201);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        
        $student = Student::where('id', $request->id)->where('otp', $request->otp)->first();
     
        if (empty($student)) 
        {
            $response = [
                'message' => 'invalid OTP',
                'status' => '0'
            ];
        }
        else
        {
           $student->is_otp_verified = 1;
           $student->save();

           $response = [
            'message' => 'otp verified',
            'status' => '1'
          ];
        } 
        return response()->json($response, 201);
    }

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $student = Student::where('email', $request->email)->first();

        if(empty($student))
        {
          $response = [
            'message' => 'email not registered',
            'status' => '0'
          ];
        }
        else
        {
            $lovRecord = LoginOtpVerification::where('email', $request->email)->first();

            if (empty($lovRecord))
            {
                $loginOtpVerification = new LoginOtpVerification();
                $loginOtpVerification->email = $request->input('email');
            } 
            else 
            {
                $loginOtpVerification = LoginOtpVerification::find($lovRecord->id);
              
            }
    
            $loginOtpVerification->otp = generateRandomOtp(6);
            $loginOtpVerification->is_verified = 0;
            $loginOtpVerification->save();
    
            $response = [
                'message' => 'otp send successfully please check email',
                'status' => '1'
            ];
        }
        return response()->json($response, 201);

    }

    public function verifyStudentLoginOtp(Request $request)
    {
        $lovRecord = LoginOtpVerification::where('email', $request->email)->where('otp', $request->otp)->first();
       
        if($lovRecord)
        {
            $lovRecord->is_verified = 1;
            $lovRecord->save();

            $response = [
                'message' => 'otp verification successful',
                'status' => '1'
            ];
        }
        else
        {
            $response = [
                'message' => 'you entered wrong otp',
                'status' => '0'
            ];
        }
        return response()->json($response, 201);

    }

    public function studentLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $credentials = $request->only('email', 'password');
        // echo '<pre>';
        // print_r($credentials);
        // die();

        if (Auth::guard('student')->attempt($credentials)) {
            $user = Auth::guard('student')->user();
        
            if ($user->status == 1) {
                $token = $user->createToken($request->email)->plainTextToken;
               // return redirect()->intended('student/dashboard');
               $response = [
                'message' => 'login success',
                'status' => '1',
                'token' => $token
            ];
                
            }else{

                Auth::guard('student')->logout(); 
               
               // return redirect()->route('studentLogin')->with('message', 'Invalid Access');
               $response = [
                'message' => 'invalid credentials',
                'status' => '0'
            ];
                
            }

            // Authentication passed...
            
        }
       // return Redirect::to("login")->with('message', 'Oppes! You have entered invalid credentials');
       $response = [
        'message' => 'Oppes! You have entered invalid credentials',
        'status' => '0'
    ];

    return response()->json($response, 201);












      
    }
}





    



   
   
