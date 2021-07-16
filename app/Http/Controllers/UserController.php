<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Session;

class UserController extends Controller
{
    //get = registration
    function showRegistrationform()
    {
        return view('registrationform');
    }

    //get = post
    function showLoginform()
    {
        return view('loginform');
    }

    //post = register
    function getRegistrationData(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'telephone' => 'required',
            'email' => 'required | unique:users',
            'password' => 'required',
            'cpassword' => 'required',
            'image' => 'required'
        ]);
        $user = new User(); // model name
        $user->name = $request->name;
        $user->telephone = $request->telephone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->cpassword = $request->cpassword;
        $user->image = $request->image;
        $req = $user->save();
        if ($req) {
            return back()->with('success', 'You have registered successfully');
        } else {
            return back()->with('fail', 'Something Wrong');
        }
    }

    //post = login
    function getloginData(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $user =  User::where('email', '=', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                // return back()->with('success', 'You have login successfully');
                $request->session()->put('loginId', $user->id);
                return redirect('dashboard');
            } else {
                return back()->with('fail', 'password not match');
            }
        } else {
            return back()->with('fail', 'email is not registered');
        }
    }

    //dashboard
    function dashboard(Request $request)
    {
        $loginUserdata = array();
        if (session()->has('loginId')) {
            $loginUserdata = User::where('id', '=', session()->get('loginId'))->first();
        }
        return view('dashboard', compact('loginUserdata'));
    }

    //logout
    function logout()
    {
        if (session()->has('loginId')) {
            session()->pull('loginId'); // pull is the function for forgot
            return redirect('loginform');
        }
    }
}
