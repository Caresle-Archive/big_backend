<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get()
    {
        $users = User::with(['posts', 'reviews'])->get();

        return $users;
    }

    public function post_or_put(Request $request)
    {
    }

    public function delete(Request $request)
    {}
}
