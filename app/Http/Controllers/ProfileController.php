<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile()
    {
        if (!User::find(auth()->id())->can('view_profile')) {
            return abort(401);
        }

        return view('profile.profile', [
            'employee' => auth()->user()
        ]);
    }
}
