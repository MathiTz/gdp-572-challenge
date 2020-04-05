<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\User as UserResource;
use App\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return UserCollection
     */
    public function index()
    {
        return new UserCollection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return UserResource|array|ResponseFactory|Response
     */
    public function store(Request $request)
    {
        $user = new User();

        if (!$request->name) {
            return \response(['error' => 'Name cannot be empty'], 400, []);
        }

        if (!$request->email) {
            return \response(['error' => 'Email cannot be empty'], 400, []);
        }

        if (!$request->password) {
            return \response(['error' => 'Password cannot be empty'], 400, []);
        }

        $userInStore = User::firstWhere('email', $request->email);

        if ($userInStore) {
            return \response(['error' => 'Email has already been used'], 400, []);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return UserResource
     */
    public function show($id)
    {
        return new UserResource(User::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return UserResource|ResponseFactory|Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) return \response(['error' => "User doesn't exist"], 400, []);

        if (!$request->name && !$request->email && !$request->password) {
            return \response(['error' => 'Please fill at least one of the fields'], 400, []);
        }

        if ($request->name) $user->name = $request->name;
        if ($request->email) $user->email = $request->email;
        if ($request->password) $user->password = $request->password;

        $user->update();

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return UserResource|ResponseFactory|Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) return \response(['error' => "User doesn't exist"], 400, []);

        $user->delete();

        return new UserResource($user);
    }
}
