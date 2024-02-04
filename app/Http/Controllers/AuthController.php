<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(AuthLoginRequest $request)
    {
        $request->validated($request->all());
        
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return $this->responseForbidden('','Credentials do not match');
        }

        $user = User::where('email', $request->email)->first();

        return $this->responseSuccess([
            'user'      => new UserResource($user),
            'token'     => $user->createToken('Token of ' . $user->name)->plainTextToken
        ]);
    }

    public function register(AuthRegisterRequest $request)
    {
        $request->validated($request->all());

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);

        return $this->responseSuccess([
            'user'  => new UserResource($user),
            'token' => $user->createToken('Token of ' . $user->name)->plainTextToken
        ]);
    }

    public function logout()
    {
        Auth::user()->currentAccesstoken()->delete();
        return $this->responseSuccess('', 'Succesfully logged out');
    }
}
