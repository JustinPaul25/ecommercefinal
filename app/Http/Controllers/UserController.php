<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\User as UserResource;
use Illuminate\Http\Request;

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
}
