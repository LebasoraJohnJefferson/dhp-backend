<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personnel\BaranggayRequest;
use App\Models\BaranggayModel;
use App\Models\CityModel;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaranggayController extends Controller
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BaranggayRequest $brgy)
    {
        $brgy->validated($brgy->all());
        BaranggayModel::create([
            'user_id'=>Auth::user()->id,
            'city_id'=>$brgy->city_id,
            'purok'=>$brgy->purok,
            'baranggay'=>$brgy->baranggay,
        ]);

        return $this->success('','Successfully added!',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $city_id)
    {
        $cityDetails = CityModel::where('id', $city_id)->with('baranggay','baranggay.user', 'province')->first();

        if (!$cityDetails) {
            return $this->error('', 'City Not Found', 404, [
                'city_id' => $city_id,
            ]);
        }
        $baranggay = $cityDetails->baranggay;
        $province = $cityDetails->province;
        return $this->success([
            'province' => $province,
            'city' => $cityDetails,
            'baranggay' => $baranggay,
        ],'',200);
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
    public function destroy(string $brgy)
    {   
        $brgy = BaranggayModel::find($brgy);
        if(!$brgy){
            return $this->error('','Baranggay not found',404);
        }
        $brgy->delete();
        return $this->success('', 'Personnel successfully deleted', 204);
    }
}
