<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Files;
use Illuminate\Support\Facades\Storage; 

class DeskController extends Controller
{
    public function index() {
        return Files::all();
    }

    public function delete($id)
    {
        // Finding the file record with the specified ID
        $file = Files::findOrFail($id);

        // return response()->json(['message' => '$id = ' . $id], 400);
        // Deleting the file from storage

        Storage::delete('public/uploads/' . $file->id . '_' . $file->original_name);

        // Deleting the file record from the database
        $file->delete();

        // Redirecting to the index view with a success message
        // return redirect()->route('files.index')->with('success', 'File deleted successfully.');
        return response()->json(['message' => 'File deleted successfully'], 200);
    }

    public function upload(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'file' => 'required|file|max:20480|mimes:jpeg,png,pdf,doc,docx', // 20 MB max size, allowed file types
            'name' => 'nullable|string',
        ]);

        // Extract file details from the request
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();

        // Create a new file record in the database
        $uploadedFile = Files::create([
            'name' => $request->input('name'),
            'original_name' => $originalName,
            'extension' => $file->getClientOriginalExtension(),
            'size' => $file->getSize(),
        ]);

        // Store the file in the 'public/uploads' directory with a unique identifier
        $file->storeAs('public/uploads', $uploadedFile->id . '_' . $originalName);

        // Return a JSON response indicating success
        return response()->json(['message' => 'File uploaded successfully', 'file' => $uploadedFile], 201);
    }

    public function download($id)
    {
        // abort(404); // File not found

        // return response()->json(['error' => 'Bad Request'], 400);


        // Finding the file record with the specified ID
        $file = Files::find($id);

        // Checking if the file exists
        if (!$file) {
            abort(404); // File not found
        }

        // Constructing the file path in the 'public/uploads' directory
        $filePath = 'public/uploads/' . $file->id . '_' . $file->original_name;

        // Ensure the file exists in the storage disk
        if (Storage::exists($filePath)) {
            // Getting the absolute path to the file
            $absolutePath = storage_path('app/' . $filePath);

            // Setting headers for the download response
            $headers = [
                'Content-Type' => $file->mime_type,
                'Content-Disposition' => 'attachment; filename="' . $file->original_name . '"', // Explicitly setting the filename
                'original_name' => $file->original_name . '.' . $file->extension,
                'Access-Control-Expose-Headers' => 'Content-Disposition, original_name',
                'Access-Control-Allow-Origin' => '*',
            ];

            // Returning a download response
            return response()->download($absolutePath, $file->original_name, $headers);
        } else {
            abort(404); // File not found in storage
        }
    }
    
    
    
    
    
    
    
}
