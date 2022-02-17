<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User\User as UserResource;

class UserController extends Controller
{
    public function myData()
    {
        return new UserResource(auth()->user());
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $user->update([
            'name' => $request->input('name'),
            'brgy' => $request->input('brgy'),
            'city' => $request->input('city'),
            'phone_no' => $request->input('phone_no'),
            'email' => $request->input('email')
        ]);

        if ($request->hasFile('image')) {
            $user->addMedia($request->file('image'))->toMediaCollection('profile');
        }

        return new UserResource(auth()->user());
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();
        return $user->update([ 'password' => Hash::make($request->input('password')) ]);
    }
}
