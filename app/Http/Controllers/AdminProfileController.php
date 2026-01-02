<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    //details
    public function details()
    {
        return view('admin.profile.details');
    }

    //edit
    public function edit()
    {
        return view('admin.profile.edit');
    }

    //update
    public function update(Request $request, $id)
    {
        $this->validationCheck($request);

        $updateData = $this->getAccountData($request);

        if ($request->hasFile('image')) {
            if (auth()->user()->profile !== null) {
                //oldImage delete
                $oldImage = auth()->user()->profile;
                if (file_exists(public_path('adminProfile/' . $oldImage))) {
                    unlink(public_path('adminProfile/' . $oldImage));

                }
            }

            //new image upload
            $newImage = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->image->move(public_path('adminProfile/'), $newImage);

            $updateData['profile'] = $newImage;

        }

        User::find($id)->update($updateData);

        return to_route('profile#details');

    }

    //change password page
    public function changePasswordPage()
    {
        return view('admin.profile.changePassword');
    }

    //change password process
    public function changePassword(Request $request)
    {
        $dbAccountPassword = auth()->user()->password;

        $this->passwordValidationCheck($request);

        $passwordCheckStatus = Hash::check($request->oldPassword, $dbAccountPassword);

        if ($passwordCheckStatus) {
            User::find(auth()->user()->id)->update(['password' => Hash::make($request->newPassword)]);
            return back()->with(['success' => 'password changed successfully']);
        }
        return back()->with(['fail' => 'password change fail. Try again!']);

    }

    //addNewAdminPage
    public function addNewAdminPage()
    {
        return view('admin.profile.addNewAdminAccount');
    }

    //addNewAdmin
    public function addNewAdmin(Request $request)
    {
        $this->checkAccountValidation($request);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin',
            'provider' => 'simple',
        ]);

        return back()->with(['success' => 'password change success']);

    }

    //adminList
    public function accountList($accountType)
    {

        $accounts = User::select('id', 'name', 'email', 'address', 'phone', 'role', 'created_at', 'provider');
        if ($accountType == 'admin') {
            $accounts = $accounts->whereIn('role', ['superadmin', 'admin']);
        } else if ($accountType == 'user') {
            $accounts = $accounts->whereIn('role', ['user']);
        }

        if (request('searchKey')) {
            $key = request('searchKey');
            $accounts->where(function ($query) use ($key) {
                $query->whereAny(['name','email','address','phone','role'],'like','%'.$key.'%');
            });
        }

        $accounts = $accounts->get();

        return view($accountType == 'admin' ? 'admin.profile.adminList' : 'admin.profile.userList', compact('accounts'));
    }

    //delete account
    public function delete($id)
    {
        User::where('id', $id)->delete();
        return back()->with(['success' => 'delete account success']);
    }

    //checkNewAdminValidation
    private function checkAccountValidation($request)
    {
        $request->validate([
            'name'            => 'required|min:1|max:30',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:5|max:20',
            'confirmPassword' => 'required|min:5|max:20|same:password',

        ]);
    }

    //password validation check
    private function passwordValidationCheck($request)
    {
        $request->validate([
            'oldPassword'     => 'required|min:5|max:20',
            'newPassword'     => 'required|min:5|max:20',
            'confirmPassword' => 'required|min:5|max:20|same:newPassword',
        ]);
    }

    private function getAccountData($request)
    {
        return [
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,

        ];

    }

    //validation check
    private function validationCheck($request)
    {
        $request->validate([
            'name'    => 'required|min:2|max:30',
            'email'   => 'required|email|min:5|max:40',
            'phone'   => 'required|min:1|max:20',
            'address' => 'required|max:200',

        ]);
    }
}
