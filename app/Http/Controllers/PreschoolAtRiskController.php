<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreschoolAtRiskRequest;
use App\Http\Resources\PreschoolAtRiskResource;
use App\Models\FamilyProfileMemberModel;
use App\Models\PreschoolAtRiskModel;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class PreschoolAtRiskController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $preschool = PreschoolAtRiskModel::with('FPM')
            ->latest()
            ->get();
        return PreschoolAtRiskResource::collection($preschool);
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
    public function store(PreschoolAtRiskRequest $pres_req)
    {
        $pres_req->validated($pres_req->all());
        PreschoolAtRiskModel::create([
            'member_id' => $pres_req->member_id,
            'weight' => $pres_req->weight,
            'height' => $pres_req->height,
            'period_of_measurement' => $pres_req->period_of_measurement,
        ]);

        return $this->success('','Successfully Added',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $children = FamilyProfileMemberModel::where(function ($query) {
            $query->whereRaw('TIMESTAMPDIFF(MONTH, birthDay, CURDATE()) >= 0');
            $query->whereRaw('TIMESTAMPDIFF(MONTH, birthDay, CURDATE()) < 60');
        })->latest()->get();

        return $this->success($children);
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
