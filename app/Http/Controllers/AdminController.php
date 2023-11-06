<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    // direct admin list page
    public function adminList()
    {
        $admins = User::when(request('searchKey'), function ($query) {
            $query->orWhere('name', 'like', '%'.request('searchKey'). '%')
            ->orWhere('email', 'like', '%' . request('searchKey') . '%')
            ->orWhere('address', 'like', '%' . request('searchKey') . '%');
        })
            ->where('role', 'admin')
            ->orderby('created_at', 'asc')
            ->paginate(3);
        // dd($admins->toArray());
        $admins->appends(request()->query());
        return view('admin.account.list', compact('admins'));
    }

    // delete admin account
    public function delete($id)
    {
        User::where('id', $id)->delete();
        return back()->with(['deleteMessage'=>'Admin Account Deleted...']);
        // dd('delete');
    }

    // direct admin role change page
    public function roleChangePage ($id) {
        $account = User::where('id', $id)->firstOrFail();
        return view('admin.account.roleChange', compact('account'));
    }

    // role change
    public function change($id, Request $request) {
        $data = [
            'role' => $request->role
        ];

        User::where('id', $id)->update($data);
        return redirect()->route('admin#list');

    }


    // direct profile detail page
    public function detail()
    {
        return view('admin.account.detail');
    }

    // direct profile edit page
    public function edit()
    {
        return view('admin.account.edit');
    }

    // profile update
    public function update(Request $request, $id)
    {
        $this->accountValidationCheck($request);
        $data = $this->getUpdateData($request);
        if ($request->hasFile('image')) {
            $dbImage = User::where('id', $id)->first();
            $dbImage = $dbImage->image;

            if ($dbImage != null) {
                Storage::delete('public/profileImage/' . $dbImage);
            }
            $imageName = uniqid() . $request->file('image')->getClientOriginalName();
            // dd($imageName);
            $request->file('image')->storeAs('public/profileImage', $imageName);
            $data['image'] = $imageName;
        }
        User::where('id', $id)->update($data);
        return redirect()->route('admin#detail')->with(['accountUpdateSuccess' => "Admin Account Updated Successfully"]);
    }


    // admin password change page
    public function changePasswordPage()
    {
        return view('admin.account.changePassword');
    }

    // admin password change
    public function changePassword(Request $request)
    {
        // dd($request->all());
        /*
            all fields are required
            check old password is correct in the db
            new password and confirm password must be greater than 6 and be less than 10 characters
            new password and confirm password must be same
        */

        $this->passwordValidationCheck($request);

        // get current user
        $user = User::where("id", Auth::user()->id)->first();
        $dbPassword = $user->password;

        // checking oldPassword is equal to hashPassword in the db
        if (Hash::check($request->oldPassword, $dbPassword)) {
            $data = [
                'password' => Hash::make($request->newPassword)
            ];

            User::where('id', Auth::user()->id)->update($data);
            // Auth::logout();
            // return redirect()->route('auth#loginPage');
            return back()->with(['changeSuccess' => 'Password Changed Success...']);
        }

        return back()->with(["notMatch" => "The Old Password doesn't match"]);
    }


    private function getUpdateData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'updated_at' => Carbon::now()
        ];
    }

    // account validation check
    private function accountValidationCheck($request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'image' => 'file|mimes:png,jpg,jpeg',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required',
        ])->validate();
    }

    private function passwordValidationCheck($request)
    {
        Validator::make($request->all(), [
            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword',
        ])->validate();

        // dd($request->all());
    }
}
