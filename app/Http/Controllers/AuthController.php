<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::Create($request->only('name', 'email')
            + [
                'password' => Hash::make($request->input('password')),
            ]
        );

        return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        if(!\Auth::attempt($request->only('email', 'password'))) {
            return response([
                'error' => 'invalid credencials',

            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = \Auth::user();

        $jwt = $user->createToken('token', ['admin'])->plainTextToken;

        $cookie = cookie('jwt', $jwt, 60*40);

        return response([
            'message' => 'success',
            'token' => $jwt
        ])->withCookie($cookie);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function logout()
    {
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'success',
        ])->withCookie($cookie);
    }

    public function update(UpdateUserRequest $request)
    {
        $user = $request->user();

        $user->update($request->only('name', 'email'));

        return \response(Response::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdateUserPasswordRequest $request)
    {
        $user = $request->user();

        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);

        return \response(Response::HTTP_ACCEPTED);
    }
}
