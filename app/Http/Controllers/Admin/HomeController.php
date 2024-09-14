<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Class 'App\Http\Controllers\Admin\Auth' not found
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\User;


class HomeController extends Controller
{
    public function profile()
    {
        return view('custom_auth.profile');
    }
    public function profile_update(Request $request)
    {
        $user= Auth::user();

        $this->validate(request(),
            [
                'name'=>'required',
                'designation'=>'required',
                'bio'=>'required',
            ]);
         $fileName = null;
        if (request()->hasFile('user_img')) 
        {
            $file = request()->file('user_img');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            $file->move('./uploads/', $fileName);
        }
        $data = $request->all();
        $data['user_img'] = $fileName;
        $user->update($data);
        return redirect()->back();
    }
    public function updatepassword(Request $request)
    {
        $request->validate([
      'current_password' => ['required', new MatchOldPassword],
      'new_password' => ['required'],
      'new_confirm_password' => ['same:new_password'],
    ]);
    User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
    return response()->json(['status' => TRUE, 'msg' => 'Password Changed Successfully!']);
    // return response()->json(['status' => true, 'msg' => 'Password Changed Successfully!'], 200);
    // return redirect()->back();
    }
}
