<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Files;

class FilesController extends Controller
{
    /**
     * Display a paginated list of files with optional search functionality.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Extracting the search query from the request input
        $search = $request->input('search');

        // Querying the Files model based on the search criteria
        $files = Files::when($search, function ($query) use ($search) {
            // Applying search filter to original_name and name columns
            return $query->where(function ($query) use ($search) {
                $query->where('original_name', 'like', '%' . $search . '%')
                         ->orWhere('name', 'like', '%' . $search . '%');
            });
        })->paginate(50);

        // Returning the view with the paginated files and the search query
        return view('files.index', compact('files', 'search'));
    }

    /**
     * Display the form for creating a new file.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('files.create');
    }

    /**
     * Store a newly created file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validating the incoming request data
        $request->validate([
            'file' => 'required|file|max:20480|mimes:jpeg,png,pdf,doc,docx', // 8 MB
            'name' => 'nullable|string',
        ]);

        // Extracting file details from the request
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();

        // Creating a new file record in the database
        $uploadedFile = Files::create([
            'name' => $request->input('name'),
            'original_name' => $originalName,
            'extension' => $file->getClientOriginalExtension(),
            'size' => $file->getSize(),
        ]);

        // Storing the file in the 'public/uploads' directory with a unique identifier
        $file->storeAs('public/uploads', $uploadedFile->id . '_' . $originalName);

        // Redirecting to the index view with a success message
        return redirect()->route('files.index')->with('success', 'File uploaded successfully.');
    }

    /**
     * Show the form for editing the specified file.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Finding the file record with the specified ID
        $file = Files::findOrFail($id);

        // Returning the view with the file details
        return view('files.edit', compact('file'));
    }

    /**
     * Update the specified file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Finding the file record with the specified ID
        $file = Files::findOrFail($id);

        // Validating the incoming request data
        $request->validate([
            'file' => 'sometimes|file|max:20480|mimes:jpeg,png,pdf,doc,docx', // 8 MB
            'name' => 'nullable|string',
        ]);

        // Handling file update or name change based on conditions
        if ($file->exists() && $request->hasFile('file')) {
            try {
                // Deleting the existing file from storage
                Storage::delete('public/uploads/' . $file->id . '_' . $file->original_name);
            } catch (\Exception $e) {
                // Handle the exception (e.g., log or display an error message)
                return redirect()->route('files.index')->with('error', 'Large file or wrong extension.');
            }

            // Extracting file details from the new file
            $newFile = $request->file('file');
            $originalName = $newFile->getClientOriginalName();

            // Updating the file record in the database
            $file->update([
                'name' => $request->input('name'),
                'original_name' => $originalName,
                'extension' => $newFile->getClientOriginalExtension(),
                'size' => $newFile->getSize(),
            ]);

            // Storing the new file in the 'public/uploads' directory with a unique identifier
            $newFile->storeAs('public/uploads', $file->id . '_' . $originalName);
        } elseif ($file->name != $request->input('name')) {
            // Updating only the file name if it has changed
            $file->update([
                'name' => $request->input('name'),
            ]);
        }

        // Redirecting to the index view with a success message
        return redirect()->route('files.index')->with('success', 'File updated successfully.');
    }

    /**
     * Remove the specified file from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        // Finding the file record with the specified ID
        $file = Files::findOrFail($id);

        // Deleting the file from storage
        Storage::delete('public/uploads/' . $file->id . '_' . $file->original_name);

        // Deleting the file record from the database
        $file->delete();

        // Redirecting to the index view with a success message
        return redirect()->route('files.index')->with('success', 'File deleted successfully.');
    }

    /**
     * Download the specified file.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        abort(404); // File not found

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
            ];

            // Returning a download response
            return response()->download($absolutePath, $file->original_name, $headers);
        } else {
            abort(404); // File not found in storage
        }
    }
}