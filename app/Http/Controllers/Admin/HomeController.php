<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Role;
use App\Admin;
use App\Permission;
use App\scooter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data = collect();
        $data->usersCount      = User::count();
        $data->adminCount      = Admin::count();
        $data->roleCount       = Role::count();
        $data->permissionCount = Permission::count();

        $data->roles = Role::all();
        $data->permissions = Permission::all();
        $data->user = User::all();
        return view('admin.home', compact('data'));
    }
    public function user()
    {
        $users = user::select()
                            ->get();
        return view('admin.user')
                ->with('users',$users);
    }
    public function adduser(Request $request)
    {
        $user = new user();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->status = 'active';
        $user->password = bcrypt($request->password);
        $user->stripe_status = $request->stripe_status;
        $user->sign_terms = $request->sign_terms;
        $user->balance = $request->balance;
        $user->api_token = $request->token;
        $user->save();
        return back();
    }
    public function deluser($id)
    {
        $user = user::select()
                    ->where('id',$id)
                    ->first();
        $user->delete();
        return back();
    }
    public function edituser(Request $request)
    {
        $user = user::select()
            ->where('id',$request->edit_id)
            ->first();
        $user->name = $request->edit_name;
        $user->stripe_status = $request->edit_stripe_status;
        $user->balance = $request->edit_balance;
        $user->sign_terms = $request->edit_sign_terms;
        $user->save();
        return back();
    }
    
    public function scooter()
    {
        $scooters = scooter::select()
                            ->get();
        return view('admin.scooter')
                ->with('scooters',$scooters);
    }
    public function addscooter(Request $request)
    {
        $scooter = new scooter();
        $scooter->name = $request->name;
        $scooter->rent_status = $request->rent_status;
        $scooter->price1 = $request->price1;
        $scooter->price2 = $request->price2;
        if ($request->hasFile('image')) {
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
              ]);
            $image = $request->file('image');
            $name = rand(11111, 99999).$_FILES["image"]["name"];
            $destinationPath = public_path('/upload/scooter');
            $imagePath = $destinationPath. "/".  $name;
            $image->move($destinationPath, $name);
            $scooter->filename = $name;
        }
        $scooter->save();
        return back();
    }
    public function delscooter($id)
    {
        $scooter = scooter::select()
                    ->where('id',$id)
                    ->first();
        $scooter->delete();
        return back();
    }
    public function editscooter(Request $request)
    {
        $scooter = scooter::select()
            ->where('id',$request->edit_id)
            ->first();
        $scooter->name = $request->edit_name;
        $scooter->rent_status = $request->edit_rent_status;
        $scooter->price1 = $request->edit_price1;
        $scooter->price2 = $request->edit_price2;
        if ($request->hasFile('image')) {
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
              ]);
            $image = $request->file('image');
            $name = rand(11111, 99999).$_FILES["image"]["name"];
            $destinationPath = public_path('/upload/scooter');
            $imagePath = $destinationPath. "/".  $name;
            $image->move($destinationPath, $name);
            $scooter->filename = $name;
        }
        $scooter->save();
        return back();
    }
}
