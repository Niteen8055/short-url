<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //

    public function AdminDashboard(){

        return view('admin.index');
    }

    public function AdminLogin(){

        return view('admin.admin_login');

    }

    public function AdminLogout(Request $request)
      {  
        
        Auth::guard('web')->logout();

        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('login/show'); 
    }

    public function AdminProfile() {

        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile_view', ['profileData' => $profileData]);
    }
    
    public function AdminProfileStore(Request $request){
        
        $id = Auth::user()->id;

        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('uploads/admin_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('uploads/admin_images'),$filename);
            $data['photo'] = $filename;
        }
        $data->save();

        $notifications = array(
            'message' => 'Admin Profile Updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notifications);
    }

    public function AdminChangePassword(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_change_password', ['profileData' => $profileData]);
    }

    public function AdminPasswordUpdate(Request $request){

        //validation

        $request->validate([
           'old_password' => 'required',
           'new_password' => 'required|confirmed',
        ]);

        if(!Hash::check($request->old_password,Auth::user()->password)){

            $notifications = array(
                'message' => 'Old Password Does Not Match',
                'alert-type' => 'error'
            );
    
            return back()->with($notifications);
        }

        //update the new password

        User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notifications = array(
            'message' => 'Password Changed Successfully',
            'alert-type' => 'success'
        );

        return back()->with($notifications);
    }



}
