<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personnel\UpdateMoreInfoOfPersonnel;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\PersonnelMoreInfo;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\UploadFile;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    use HttpResponses;
    use UploadFile;
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


    public function MoreInfo(UpdateMoreInfoOfPersonnel $moreInfo){
        $moreInfo->validated($moreInfo->all());
        $user_id = Auth::user()->id;

        $is_personnel_info_exist = PersonnelMoreInfo::where('user_id',$user_id)->first();
        $file_name = $this->UploadFile($moreInfo->image);

        if($is_personnel_info_exist){
            $moreInfo['image'] = $file_name ? $file_name : $is_personnel_info_exist->image;
        }

        if($is_personnel_info_exist){
            $is_personnel_info_exist->update($moreInfo->all());
        }else{
            PersonnelMoreInfo::create([
                'user_id'=>$user_id,
                'image'=>$file_name,
                'address'=>$moreInfo->address,
                'birthday'=>$moreInfo->birthday,
                'gender'=>$moreInfo->gender,
                'contact_number'=>$moreInfo->contact_number,
                'emergency_contact_relationship'=>$moreInfo->emergency_contact_relationship,
                'emergency_contact_number'=>$moreInfo->emergency_contact_number,
            ]);
        }


        $this->success(null,'Successfully uploaded',201);
    }


    public function updateAdminInfo(Request $request){
        $request->validate([
            'email' => ['required', 'email'],
            'image' => ['string', 'nullable'],
            'first_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255', Rules\Password::defaults()],
        ]);
        $user = User::find(Auth::user()->id);
        $user_id = Auth::user()->id;
        $is_personnel_info_exist = PersonnelMoreInfo::where('user_id',$user_id)->first();
        if(!$user) return $this->error('','User not found!',409);

        $file_name = $this->UploadFile($request->image);

        if($is_personnel_info_exist){
            $request['image'] = $file_name ? $file_name : $is_personnel_info_exist->image;
        }

        $is_email_exist = User::where('email',$request->email)
        ->where('id','!=',Auth::user()->id)
        ->first();

        if($is_email_exist) return $this->error('','Email already exist!',409);

        if($is_personnel_info_exist){
            $is_personnel_info_exist->update(['image'=>$file_name]);
        }else{
            PersonnelMoreInfo::create([
                'user_id'=>$user_id,
                'image'=>$file_name,
                'address'=>'N/A',
                'birthday'=>date('Y-m-d'),
                'gender'=>'N/A',
                'contact_number'=>'N/A',
                'emergency_contact_relationship'=>'N/A',
                'emergency_contact_number'=>'N/A',
            ]);
        }


        $user->update([
            'first_name'=>$request->first_name,
            'email'=>$request->email,
            'password'=>$request->password
            ]
        );


        $this->success(null,'Successfully uploaded',201);
    }


}
