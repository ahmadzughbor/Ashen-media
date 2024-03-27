<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class passwordController extends Controller
{
    public function index()
    {


        return view('admin.password.index');
    }


    public function store(Request $request)
    {
        // dd($request);
        $user = Auth::user();
        $check = Hash::check($request->password, $user->password);
       
        
        $Confirm_password = $request->Confirm_password;
        $New_password = $request->New_password;
        
        if(!$check){
            return response()->json('The password is incorrect' , 500);
        }
        
        if($Confirm_password ==  $New_password && $New_password != null ){
            $user->update([
                'password' => Hash::make($New_password) ,
            ]);
            return response()->json( $user, 200);
        }
        
        return response()->json('The password is not the same' , 500);
        
        // dd($user);

        // return $user;
    }
}
