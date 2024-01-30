<?php

namespace App\Http\Controllers;

use App\Http\Resources\FileResource;
use App\Models\fileModel;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecoverFilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HttpResponses;
    public function index()
    {
        $user = Auth::user();
        $files = $user->roles == 'admin' ? 
        fileModel::where('is_deleted', true)->get() : 
        fileModel::where('is_deleted', true)
            ->where('user_id', $user->id)->get();
        return FileResource::collection($files);
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
        $files = fileModel::where('is_deleted', true)
        ->where('user_id', $id)->get();
         return FileResource::collection($files);
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
    public function update(Request $request, string $id)
    {
        $file = fileModel::find($id);
        if(!$file){
            return $this->error('','File not found',404);
        }
        $file->update(['is_deleted'=>false]);
        return $this->success('',"Successfully recovered",200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $file = fileModel::find($id);
        if(!$file){
            return $this->error('','File not found',404);
        }
        if($file->is_deleted === false){
            return $this->error('','File cant be deleted',409);
        }
        $file->delete();
        return $this->success('',"Successfully deleted",204);
    }
}
