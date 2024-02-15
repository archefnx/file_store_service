<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

use App\Models\Files;

class FilesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $files = Files::when($search, function ($query) use ($search) {
            return $query->where('original_name', 'like', '%' . $search . '%');
        })->paginate(50);

        return view('files.index', compact('files', 'search'));
    }

    public function create()
    {
        return view('files.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:8192|mimes:jpeg,png,pdf', // 8 MB
            'name' => 'nullable|string',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();

        $uploadedFile = Files::create([
            'name' => $request->input('name'),
            'original_name' => $originalName,
            'extension' => $file->getClientOriginalExtension(),
            'size' => $file->getSize(),
            'path' => 'uploads/' . $originalName,
        ]);

        $file->storeAs('uploads', $originalName);

        return redirect()->route('files.index')->with('success', 'File uploaded successfully.');
    }

    public function edit($id)
    {
        $file = Files::findOrFail($id);

        return view('files.edit', compact('file'));
    }

    public function update(Request $request, $id)
    {
        $file = Files::findOrFail($id);

        $request->validate([
            'file' => 'sometimes|file|max:8192|mimes:jpeg,png,pdf', // 8 MB
            'name' => 'nullable|string',
        ]);

        if ($file->exists() && $request->hasFile('file')) {
            try {
                Storage::delete('uploads/' . $file->id . '_' . $file->original_name);
            } catch (\Exception $e) {
                // Handle the exception (e.g., log or display an error message)
            }

            $newFile = $request->file('file');
            $originalName = $newFile->getClientOriginalName();

            $file->update([
                'name' => $request->input('name'),
                'original_name' => $originalName,
                'extension' => $newFile->getClientOriginalExtension(),
                'size' => $newFile->getSize(),
                'path' => 'uploads/' . $originalName,
            ]);

            $newFile->storeAs('uploads', $file->id . '_' . $originalName);
        } elseif ($file->name != $request->input('name')) {
            $file->update([
                'name' => $request->input('name'),
            ]);
        }

        return redirect()->route('files.index')->with('success', 'File updated successfully.');
    }

    public function delete($id)
    {
        $file = Files::findOrFail($id);

        Storage::delete('uploads/' . $file->id . '_' . $file->original_name);

        $file->delete();

        return redirect()->route('files.index')->with('success', 'File deleted successfully.');
    }
    
    public function download($id)
    {
        $file = Files::find($id);

        if (!$file) {
            abort(404); // File not found
        }

        // Ensure the file exists in the storage disk
        if (Storage::exists($file->path)) {
            $path = Storage::path($file->path);
            $headers = [
                'Content-Type' => $file->mime_type,
            ];

            return response()->download($path, $file->original_name, $headers);
        } else {
            abort(404); // File not found in storage
        }
    }
}
