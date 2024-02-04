<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use HttpResponses;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->responseSuccess(UserResource::collection(User::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $request->validated($request->all());
        
        $user = User::create([
            'name'      => ucwords($request->name),
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);

        return $this->responseCreated(new UserResource($user));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return $this->responseSuccess(new UserResource($user));
        } catch (\Exception $e) {
            return $this->responseNotFound('', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $request->validated($request->all());
        try {
            $user = User::findOrFail($id);
            $user->update([
                'name'      => ucwords($request->name),
                'email'     => $request->email,
                'password'  => Hash::make($request->password)
            ]);
            return $this->responseSuccess(new UserResource($user), 'successfully updated data');
        } catch (\Exception $e) {
            return $this->responseNotFound('', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return $this->responseSuccess([], 'successfully deleted data');
        } catch (\Exception $e) {
            return $this->responseNotFound('', $e->getMessage());
        }
    }
}
