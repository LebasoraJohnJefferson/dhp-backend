<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personnel\ProvinceRequest;
use App\Http\Resources\ProvinceResource;
use App\Models\ProvinceModel;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProvinceController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProvinceResource::collection(ProvinceModel::all());
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
    public function store(ProvinceRequest $province)
    {
        $province->validated($province->all());
        ProvinceModel::create([
            'user_id'=>Auth::user()->id,
            'province'=>$province->province
        ]);

        return $this->success('','Successfully added!',201);
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
    public function destroy(ProvinceModel $province)
    {
        $province->delete();
        return $this->success('', 'Personnel successfully deleted', 204);
    }
}
