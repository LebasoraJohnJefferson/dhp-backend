<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return UserResource::collection([$user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function BasicInfo(UpdateUserRequest $request){
        $user = User::find(Auth::user()->id);
        if (!$user) {
            return $this->error('', 'User not found', 404);
        }

        $isEmailAlreadyExist = User::where('email', $request->email)
                ->where('id', '!=', $user->id)
                ->exists();

        if($isEmailAlreadyExist){
            return $this->error('','Email already taken!',409);
        }


        $user->update($request->all());
        return $this->success('','Successfully updated',201);
    }
}
