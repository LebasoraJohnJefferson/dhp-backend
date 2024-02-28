<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\LogModel;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PersonnelController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('roles', 'personnel')
                ->where('is_deleted', false)
                ->latest()
                ->get();

        return UserResource::collection($users);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $request->validated($request->all());
        $user = User::create([
            'first_name'=>$request->first_name,
            'middle_name'=>$request->middle_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'suffix'=>$request->suffix,
            'password'=>Hash::make($request->password),
            'is_active'=>$request->is_active
        ]);

        LogModel::create([
            'user_id'=>$user->id,
            'title'=>'Authentication',
            'description'=>'Account Created'
        ]);

        return $this->success([
            'user'=>$user,
            'token'=> $user->createToken('API token of' . $user->name)->plainTextToken
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::where('roles','personnel')
            ->where('id',$id)
            ->where('is_deleted',false)
            ->first();

        if(!$user){
            return $this->error('','Personnel Not Found',404);
        }
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id,UpdateUserRequest $request)
    {


        $user = User::find($id);

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->error('', 'Personnel not found', 404);
        }

        $user->update(['is_deleted' => true]);


        return $this->success('', 'Personnel successfully deleted', 204);
    }


    public function change_personnel_status(Request $request){
        error_log($request->id);
        $user = User::where('id',$request->id)->first();
        if(!$user){
            return $this->error('','Personnel not found',404);
        }
        $user->update(['is_active'=>!$user->is_active]);
        $status = $user->is_active ? 'active!' : 'inactive!';
        return $this->success('','Successfully set to ' . $status ,200);
    }


}
