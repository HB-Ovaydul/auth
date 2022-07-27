<?php

namespace App\Http\Controllers\frontend;

use App\Models\patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    /**
     * Patient Resgister Page
     */
    public function ShowRegisterPage()
    {
       return view('project.patient.register');
    }
    /**
     * Patient Resgister Page
     */
    public function ShowDeshbordPage()
    {
       return view('project.patient.deshboard');
    }
    /**
     * Patient Resgister Page
     */
    public function ShowProfilePage()
    {
       return view('project.patient.profile_settings');
    }
    /**
     * Patient Resgister Page
     */
    public function ShowChangePassPage()
    {
       return view('project.patient.password');
    }
    /**
     * Patient Resgister Page
     */
    public function Patient_Register(Request $request)
    {
      // User Data Validate
      $this->validate($request,[
         'email' => 'required|email|',
         'mobile' => 'required',
      ]);

      // Create User Account
   $user = patient::create([
         'fname' => $request->fname,
         'email' => $request->email,
         'mobile' => $request->mobile,
         'password' => password_hash($request->password, PASSWORD_DEFAULT),
      ]);

      // Retrun User Login Page
      return redirect()->route('show.login.page')->with('success' , 'Hi '.$user->fname.' Account Created Successful. Now log In Please');
    }

    // User Login
    public function Patient_login(Request $request)
    {
        // User Data Validate
      //   $this->validate($request,[
      //    'email' => 'required|exists:email,email',
      //    'password' => 'required|confirmed',
      // ]);

      // User Login Process
      if(Auth::guard('patient')->attempt(['email' => $request->email, 'password' => $request->password])){
         return redirect()->route('patient.desh.page');
      }else{
         return back()->with('danger','Login Faield!');
      }
    }
}
