<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ImportPersonnelContoller extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $personnelData = $request->input('personnel');

        if (!empty($personnelData) && is_array($personnelData)) {
            foreach ($personnelData as $person) {
                $first_name = $person['first_name'];
                $middle_name = $person['middle_name'];
                $last_name = $person['last_name'];
                $email = $person['email'];
                $suffix =$person['suffix'];
                $is_active = $person['is_active'];
                if(
                    !empty($first_name) &&
                    !empty($middle_name) &&
                    !empty($last_name) &&
                    !empty($email) &&
                    !empty($is_active)
                ){
                    $existingUser = User::where('email', $email)->first();

                    if (!$existingUser) {
                        $user = User::create([
                            'first_name' => $first_name,
                            'middle_name' => $middle_name,
                            'last_name' => $last_name,
                            'email' => $email,
                            'suffix'=>$suffix,
                            'password' => Hash::make('password123'),
                            'is_active' => $is_active
                        ]);
                    }
                }
            }
            return $this->success("","Successfully Imported",204);
        }

        return $this->error('','File is Empty',400);

        
        


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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
