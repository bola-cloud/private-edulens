<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function create($sectionId)
    {
        $section = Section::findOrFail($sectionId);
        return view('admin.media.create', compact('section'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'required|integer',
            'type' => 'required|in:file,video',
            'path' => 'max:2048',
            'section_id' => 'required|exists:sections,id',
        ]);
    
        $data = $request->all();
    
        if ($request->type === 'file' && $request->hasFile('path')) {
            $file = $request->file('path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('media', $filename,'public_images');
            $data['path'] = 'images/media/' . $filename;
        }
    
        Media::create($data);
    
        return redirect()->route('sections.show', $request->section_id)->with('success', 'Media added successfully');
    }
    
    public function editMedia($id)
    {
        $media = Media::findOrFail($id);
        // You can add any additional logic here if needed
        return view('admin.media.edit', compact('media'));
    }

    public function updateMedia(Request $request, $id)
    {
        // Print the request data for debugging
        // dd($request->all());
    
        $media = Media::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'required|integer',
            'type' => 'required|in:file,video',
            'path' => 'required_if:type,video',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
        ]);
    
        $data = $request->only(['name', 'content', 'order', 'type']);
    
        if ($request->type === 'file' && $request->hasFile('file')) {
            // Delete old file if it exists
            if ($media->path && file_exists(public_path($media->path))) {
                Storage::disk('public_images')->delete(str_replace('images/', '', $media->path));
            }
    
            // Store new file
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('media', $filename, 'public_images');
            $data['path'] = 'images/media/' . $filename;
        } elseif ($request->type === 'video') {
            $data['path'] = $request->path;
        }
    
        $media->update($data);
    
        return redirect()->back()->with('success', 'تم تحديث الوسائط بنجاح.');
    }
    
    
    

    public function show($id)
    {
        $media = Media::findOrFail($id);
        return view('admin.media.show', compact('media'));
    }

    public function deleteMedia($id)
    {
        $media = Media::findOrFail($id);
        $media->delete();

        return redirect()->back()->with('success', 'تم حذف الوسائط بنجاح.');
    }

    
}
