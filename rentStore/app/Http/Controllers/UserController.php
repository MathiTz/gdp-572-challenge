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
            return \response('Error: Name cannot be empty', 400, []);
        }

        if (!$request->email) {
            return \response('Error: Email cannot be empty', 400, []);
        }

        if (!$request->password) {
            return \response('Error: Password cannot be empty', 400, []);
        }

        $userInStore = User::firstWhere('email', $request->email);

        if ($userInStore) {
            return \response('Error: Email has already been used', 400, []);
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
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return UserResource
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$request->name && !$request->email && !$request->password) {
            return \response('Error: Please fill at least one of the fields', 400, []);
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
     * @return UserResource
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return new UserResource($user);
    }
}
