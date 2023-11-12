<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function get()
    {
        $redis_users = Redis::get("users");

        if (isset($redis_users))
            return ApiResponses::response('Data cached', json_decode($redis_users));

        $users = User::with(['posts', 'reviews'])->get();

        Redis::set('users', $users);
        return ApiResponses::response('Data Fetched', $users);
    }

    public function post_or_put(Request $request)
    {
        $json = json_decode($request->getContent());

        // Validate if the id is passed
        $validator = Validator::make((array)$json, [
            'id' => 'nullable|integer|exists:users,id',
        ]);

        if ($validator->fails())
            return ApiResponses::response('Validation Errors', $validator->errors(), 400);

        $id = isset($json->id) ? $json->id : null;

        $username_rules = [
            'required',
            'string',
            'min:3',
            'max:255',
            'unique:users,username',
        ];
        $email_rules = ['required', 'email', 'unique:users,email'];

        // Add rules for update
        if (isset($id)) {
            // We ovewrite the last rule that it's what containts
            // the unique clasure to check
            $email_rules[count($email_rules) - 1] = Rule::unique('users', 'email')->ignore($id);

            $username_rules[count($username_rules) - 1] = Rule::unique('users', 'username')->ignore($id);
        }

        // General Validations
        $validator = Validator::make((array)$json, [
            'username' => $username_rules,
            'password' => 'required|string|min:3|max:255',
            'email' => $email_rules,
            'country' => 'required|string|min:3|max:255',
        ]);

        if ($validator->fails())
            return ApiResponses::response('Validation Errors', $validator->errors(), 400);

        $user_data = [
            'username' => $json->username,
            'password' => bcrypt($json->password),
            'email' => $json->email,
            'country' => $json->country,
        ];

        Redis::del('users');
        // update
        if (isset($id)) {
            $user = User::where('id', $id)->update($user_data);
            return ApiResponses::response('Action Acomplish', $user);
        }

        $user = User::create($user_data);

        return ApiResponses::response('Action Acomplish', $user);
    }

    public function delete(Request $request)
    {
        $json = json_decode($request->getContent());

        $validator = Validator::make((array)$json, [
            'id' => 'required|integer|exists:users,id',
        ]);

        // In case doesn't exists in the db we don't need to
        // Clear the redis cache
        if ($validator->fails()) {
            // Just for have a log of the request send
            \Illuminate\Support\Facades\Log::debug($validator->errors());
            return ApiResponses::response('User deleted', []);
        }

        User::where('id', $json->id)->delete();
        Redis::del('users');
        return ApiResponses::response('User deleted', []);
    }
}
