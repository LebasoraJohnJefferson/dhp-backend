<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personnel\FamiltyProfileChildRequest;
use App\Http\Resources\FamilyProfileChildResource;
use App\Models\FamilyProfileChildModel;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class FamilyProfileChildController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
    public function store(FamiltyProfileChildRequest $familty_prof_child)
    {
        $familty_prof_child->validated($familty_prof_child->all());

        FamilyProfileChildModel::create([
            'FP_id'=>$familty_prof_child->FP_id,
            'name'=>$familty_prof_child->name,
            'birthDay'=>$familty_prof_child->birthDay,
            'nursing_type'=>$familty_prof_child->nursing_type
        ]);
        return $this->success('','Successfully added!',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $FP_id)
    {
        return FamilyProfileChildResource::collection(FamilyProfileChildModel::where('FP_id',$FP_id)
        ->get()); 
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
    public function destroy(string $FPCid)
    {
        $FP = FamilyProfileChildModel::find($FPCid);
        if(!$FP){
            return $this->error('','Profile family not found',404);
        }
        $FP->delete();
        return $this->success('', 'Successfully deleted', 204);
    }
}
