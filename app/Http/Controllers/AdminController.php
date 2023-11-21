<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    // user contact messages
    public function contactList()
    {
        $userMessages = DB::table('contacts')->get();
        return view('admin.contact.contactList', compact('userMessages'));
    }

    // show contact message
    public function contactMessage($id)
    {
        $message = DB::table('contacts')->where('id', $id)->first();
        return view('admin.contact.message', compact('message'));
    }

    // direct admin list page
    public function adminList()
    {
        // $adminRole = request('adminRole');
        // $admins = User::when(request('searchKey'), function ($query) {
        //     $query->orWhere('name', 'like', '%' . request('searchKey') . '%')
        //     ->orWhere('email', 'like', '%' . request('searchKey') . '%')
        //     ->orWhere('address', 'like', '%' . request('searchKey') . '%')
        //         ->where('role', 'admin');
        // })
        //     ->where('role', 'admin')
        //     ->orderby('created_at', 'asc')
        //     ->paginate(2);

        $admins = User::when(request('searchKey'), function ($query) {
            return $query->where('role', 'admin')
                    ->where(function ($q) {
                        $q->orwhere('email', 'like', '%' . request('searchKey') . '%')
                        ->orwhere('address', 'like', '%' . request('searchKey') . '%');
                });
        })
            ->where('role', 'admin')
            ->orderby('created_at', 'desc')
            ->paginate(2);

        // dd($admins);

        $admins->appends(request()->query());
        return view('admin.account.list', compact('admins'));
    }

    // direct normal user list
    public function normalUserList()
    {
        // $searchKey = $request->searchKey
        // search key ရှိလို့စစ်တဲ့အခါ orwhere တိုက်ရိုက်သုံးထားရင် မဆိုင်တဲ့ admin role တွေပါပြမှာ
        // where ထဲမှာ function ဘာလို့ထပ်ရေးလည်းဆိုတော့ where သည် and operator ကို သုံးထားတဲ့ဖြစ်တဲ့အတွက်
        // user သည် normal user , searchKey လည်း ရှိတယ်ဆိုမှ result တွေပြမှာ
        // တစ်ခုခုမမှန်ဘူးဆို result , record တွေပြမှာမဟုတ်ဘူး
        $normalUsers = User::when(request('searchKey'), function ($query) {
            // $searchKey = $request->searchKey;
            $query->where('role', 'user')
                ->where(function ($q) {
                    $q->orwhere('name', 'like', '%' . request('searchKey') . '%')
                        ->orwhere('address', 'like', '%' . request('searchKey') . '%');
                });
        })
            ->where('role', 'user')
            ->orderby('created_at', 'desc')
            ->paginate(2);

        $normalUsers->appends(request()->query());
        return view('admin.account.userList', compact('normalUsers'));
    }

    // role change for normal user to admin
    public function userRoleChange(Request $request)
    {
        User::where('id', $request->userId)->where('role', 'user')
            ->update([
                'role' => $request->role
            ]);
    }


    // delete admin account
    public function delete($id)
    {
        User::where('id', $id)->delete();
        return back()->with(['deleteMessage' => 'Admin Account Deleted...']);
        // dd('delete');
    }


    public function deleteNormalUser($id)
    {
        User::where('id', $id)->delete();
        $normalUsers = User::paginate(2);

        return view('admin.account.userList', compact('normalUsers'));
    }

    // direct admin role change page
    // public function roleChangePage ($id) {
    //     $account = User::where('id', $id)->firstOrFail();
    //     return view('admin.account.roleChange', compact('account'));
    // }

    // user role change
    public function roleChange(Request $request)
    {
        logger($request->userId);
        User::where('id', $request->userId)
            ->update([
                'role' => $request->role
            ]);
        return response()->json(['status' => 'success'], 200);
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
