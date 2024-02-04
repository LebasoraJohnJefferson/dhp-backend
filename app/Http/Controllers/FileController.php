<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Http\Resources\FileResource;
use App\Models\fileModel;
use App\Models\User;
use App\Traits\HttpResponses;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    use UploadFile;
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $files = $user->roles === 'admin' ? 
        fileModel::where('is_deleted',false)->get() : fileModel::where('user_id', $user->id)
        ->where('is_deleted',false)
        ->get();
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
    public function store(FileRequest $file)
    {
        $file->validated($file->all());
        $file_name = $this->UploadFile($file->file_name);
        fileModel::create([
            'file_name'=>$file_name,
            'name'=>$file->name,
            'user_id'=>Auth::user()->id
        ]);

        $this->success(null,'Successfully uploaded',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user_id)
    {
       $files = fileModel::where(
        'user_id',$user_id
       )
       ->where('is_deleted',false)
       ->get();

       return FileResource::collection($files);
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
    public function destroy(fileModel $file)
    {
        $file->update(['is_deleted'=>true]);
        return $this->success('', 'Successfully deleted', 204);
    }


    public function download($filename){
        $path = public_path('storage/' . $filename);

        // Check if the file exists before attempting to download
        $path = public_path('storage/' . $filename);

        if (!Storage::disk('public')->exists($filename)) {
            abort(404);
        }
        

        $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);

        $headers = [
            'Content-Type' => 'application/' . $fileExtension,
        ];

        return response()->download($path, $filename, $headers);
    }
}
