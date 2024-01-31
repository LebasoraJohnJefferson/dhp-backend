<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personnel\CityRequest;
use App\Http\Resources\CityResource;
use App\Models\CityModel;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CityResource::collection(CityModel::all()); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityRequest $city)
    {
        $city->validated($city->all());
        $is_exist = CityModel::where('province_id',$city->province_id)
            ->where('city',$city->city)
            ->first();
        if($is_exist){
            return $this->error('','Already exist',404);
        }
        CityModel::create([
            'user_id'=>Auth::user()->id,
            'city'=>$city->city,
            'province_id'=>$city->province_id
        ]);

        return $this->success('','Successfully added!',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $request)
    {
       
        $cities = CityModel::where('province_id', $request)->get();

        return CityResource::collection($cities);
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
    public function destroy(CityModel $city)
    {
        $city->delete();
        return $this->success('', 'Personnel successfully deleted', 204);
    }
}
