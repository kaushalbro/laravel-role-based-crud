<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class userProfileController extends Controller
{
    public function show($id)
    {
        // if (Auth::id() === $id) {
        //     dd('allowed');
        // } else {
        //     dd('not have permission to lookup other profile');
        // }
        $user = User::find($id);
        return view('profiles.index', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('profiles.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'image' => 'nullable|max:2048',
            'password' => 'same:confirm-password',
        ]);
        $input = $request->all();
        $user = User::find($id);
        if ($request->hasFile('image')) {
            if ($user->image) {
                @unlink($user->image);
            }
            $filename = $request->image;
            $newName = time() . '-' . $filename->getClientOriginalName();
            $input['image'] = 'storage/profile_image/' . $newName;
            $request->image->storeAs('public/profile_image/', $newName);
        }
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        $user->update($input);
        return redirect()->route('profile.show', $id)->with('success', 'Profile updated successfully');
    }
}
