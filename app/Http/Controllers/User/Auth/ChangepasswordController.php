<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Hash, Auth;
use App\Models\Customer;

class ChangepasswordController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('user.auth.passwords.changepassword');
    } 
   
  

    public function changepassword(Request $request)
    {

        $request->validate([

          'current_password' => 'required',
          'password' => 'required|string|min:8|confirmed',
          'password_confirmation' => 'required',

        ]);

        if($request->current_password == $request->password){

            return back()->with('error', 'Su nueva contraseña no puede ser la misma que su contraseña anterior. Por favor elige una nueva contraseña.');

        }else{
            $user = Auth::guard('customer')->user();
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = Hash::make($request->password);
                $user->save();
                Auth::guard('customer')->logout();

                return  redirect()->route('auth.login')->with('success', '¡Su contraseña ha sido cambiada exitosamente!');
            }
            else{
                
                return back()->with('error', 'Current password does not match!');
            }
        }
        
    } 
}
