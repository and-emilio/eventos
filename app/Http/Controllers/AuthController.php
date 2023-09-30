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
        try {
            $user = User::Create($request->only('name', 'email')
                + [
                    'password' => Hash::make($request->input('password')),
                ]
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'status' => 'success',
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        try {
            if(!\Auth::attempt($request->only('email', 'password'))) {
                return response([
                    'error' => 'invalid credencials',

                ], Response::HTTP_UNAUTHORIZED);
            }

            $user = \Auth::user();

            $jwt = $user->createToken('token', ['admin'])->plainTextToken;

            $cookie = cookie('jwt', $jwt, 60*40);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'status' => 'success',
        ])->cookie($cookie)->setStatusCode(Response::HTTP_CREATED);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function logout()
    {
        try {
            $cookie = Cookie::forget('jwt');
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'status' => 'success',
        ], Response::HTTP_ACCEPTED);
    }

    public function update(UpdateUserRequest $request)
    {
        try {
            $user = $request->user();

            $user->update($request->only('name', 'email'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ], Response::HTTP_ACCEPTED);
        }

        return response()->json([
            'status' => 'success',
        ], Response::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdateUserPasswordRequest $request)
    {
        try {
            $user = $request->user();

            $user->update([
                'password' => Hash::make($request->input('password'))
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'status' => 'success',
        ], Response::HTTP_ACCEPTED);
    }
}
