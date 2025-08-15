<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStorybookRequest;
use App\Http\Requests\UpdateStorybookRequest;
use App\Models\Storybook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class StorybookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // For public view, only show published storybooks
        $query = Storybook::with('pages');
        
        // If user is not authenticated, only show published storybooks
        if (!auth()->check()) {
            $query->published();
        }
        
        $storybooks = $query->latest()->paginate(12);
        
        return Inertia::render('storybooks/index', [
            'storybooks' => $storybooks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('storybooks/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStorybookRequest $request)
    {
        $validated = $request->validated();
        
        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')
                ->store('storybooks/covers', 'public');
        }

        $storybook = Storybook::create($validated);

        return redirect()->route('storybooks.show', $storybook)
            ->with('success', 'Storybook created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Storybook $storybook)
    {
        $storybook->load('pages');
        
        return Inertia::render('storybooks/show', [
            'storybook' => $storybook
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Storybook $storybook)
    {
        return Inertia::render('storybooks/edit', [
            'storybook' => $storybook
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStorybookRequest $request, Storybook $storybook)
    {
        $validated = $request->validated();
        
        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover image
            if ($storybook->cover_image) {
                Storage::disk('public')->delete($storybook->cover_image);
            }
            
            $validated['cover_image'] = $request->file('cover_image')
                ->store('storybooks/covers', 'public');
        }

        $storybook->update($validated);

        return redirect()->route('storybooks.show', $storybook)
            ->with('success', 'Storybook updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Storybook $storybook)
    {
        // Delete associated files
        if ($storybook->cover_image) {
            Storage::disk('public')->delete($storybook->cover_image);
        }
        
        // Delete page files
        foreach ($storybook->pages as $page) {
            if ($page->image_path) {
                Storage::disk('public')->delete($page->image_path);
            }
            
            if ($page->audio_paths) {
                foreach ($page->audio_paths as $audioPath) {
                    Storage::disk('public')->delete($audioPath);
                }
            }
        }

        $storybook->delete();

        return redirect()->route('storybooks.index')
            ->with('success', 'Storybook deleted successfully.');
    }


}