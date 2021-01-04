<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResourceCollection;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index(): UserResourceCollection
    {
        return new UserResourceCollection(User::all());
    }

    public function show($id): UserResource
    {
        $user = User::find($id);

        return new UserResource($user);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required',
            'email'                 => 'unique:users|required|email',
            'password'              => 'required|min:6|confirmed',
        ]);

        $request['password'] = bcrypt($request->password);

        $user = User::create($request->all());

        return new UserResource($user);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'password' => 'confirmed|min:6|max:12'
        ]);

        $user = User::find($id);

        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->password     = bcrypt($request->password);
        $user->save();

        return new UserResource($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        return "User deleted";
    }

    public function delete()
    {
        User::truncate();

        return "All users deleted";
    }
}   
