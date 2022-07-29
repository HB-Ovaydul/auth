<?php

namespace App\Http\Controllers\frontend;

use App\Models\patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\PatientAccountNotification;

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
   $token = md5(time().rand());
   $user = patient::create([
         'fname' => $request->fname,
         'email' => $request->email,
         'mobile' => $request->mobile,
         'token'  => $token,
         'password' => password_hash($request->password, PASSWORD_DEFAULT),
      ]);
      $user->notify(new PatientAccountNotification($user));


      // Retrun User Login Page
      return redirect()->route('patient.rag.page')->with('success' , 'Hi '.$user->fname.' Please Check Your Email Acctive Your Account');
    }

    /**
     *  User Account Active Token
     */

   public function Account_Active_Token(Request $request, $token = null)
   {
      // Chack Token
      if(!$token){
         return redirect()->route('show.login.page')->with('danger','Your Account Not Activate');
      }

      // Confirme Token
      if($token){
       $patient_token = patient::where('token', $token)->first();
            // Token Update
            if($patient_token){
            $patient_token->update([
               'token' => null,
               'status' => true,
            ]);
            return redirect()->route('show.login.page')->with('success', 'Activated Your Account , Now Log In');
         }
      }
   }

   /**
    * User Login
    */
    public function Patient_login(Request $request)
    {
        // User Data Validate
      //   $this->validate($request,[
      //    'email' => 'required|exists:email,email',
      //    'password' => 'required|confirmed',
      // ]);

      // User Login Process
      if(Auth::guard('patient')->attempt(['email' => $request->email, 'password' => $request->password]) || Auth::guard('patient')->attempt(['mobile' => $request->email, 'password' => $request->password]) ){

         // User Login Confirmed with token
         if(Auth::guard('patient')->user()->token == null && Auth::guard('patient')->user()->status == true){
            return redirect()->route('patient.desh.page');
         }else{
            return back()->with('danger', 'Your Account Not Activate');
         }
         
      }else{
         return back()->with('danger','Your Account Not veryfied');
      }
    }

    /**
     *  User Log Out Process
     */
    public function Patient_logout()
    {
      Auth::guard('patient')->logout();
      return redirect()->route('show.login.page');
    }

    /**
     * Patient Password Change
     */
    public function password_change(Request $request)
    {
     // Validate 
     $this->validate($request,[
      'old_password' => 'required',
      'new_password' => 'required',
      'password_confirmation' => 'required',
     ]);

     // password Verify
     if(!password_verify($request->old_password, Auth::guard('patient')->user()->password)){
      return back()->with('danger','Sorry Old Password Not Match');
     }

     // Password Confirm
     if($request->new_password != $request->password_confirmation){
      return back()->with('danger','Sorry Your Confirm Password Not Match');
     }

     // Password Update
   $pass_update = patient::findOrFail(Auth::guard('patient')->user()->id);
   $pass_update->update([
      'password'  => Hash::make($request->new_password),
   ]);
   return redirect()->route('show.login.page')->with('success','Your Password Changed Successful!');  

   }

}
