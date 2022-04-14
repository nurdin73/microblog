<?php

namespace App\Http\Controllers;

use App\Repositories\ProfileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $profileRepository;
    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function index()
    {
        $user = $this->profileRepository->get(auth()->id());
        return view('admin.profile.index', compact('user'));
    }

    public function changePassword()
    {
        return view('admin.profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = $this->profileRepository->get(auth()->id());
        if (!$user->password) {
            return redirect()->back()->withErrors(['old_password' => 'Password is not set']);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'Old password is incorrect']);
        }

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.profile.index')->with('success', 'Password has been changed');
    }
}
