<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStorybookPageRequest;
use App\Http\Requests\UpdateStorybookPageRequest;
use App\Models\Storybook;
use App\Models\StorybookPage;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class StorybookPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Storybook $storybook)
    {
        $pages = $storybook->pages()->paginate(10);
        
        return Inertia::render('storybooks/pages/index', [
            'storybook' => $storybook,
            'pages' => $pages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Storybook $storybook)
    {
        $nextPageNumber = $storybook->pages()->max('page_number') + 1;
        
        return Inertia::render('storybooks/pages/create', [
            'storybook' => $storybook,
            'nextPageNumber' => $nextPageNumber
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStorybookPageRequest $request, Storybook $storybook)
    {
        $validated = $request->validated();
        $validated['storybook_id'] = $storybook->id;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')
                ->store('storybooks/pages/images', 'public');
        }
        
        // Handle audio uploads
        $audioPaths = [];
        if ($request->hasFile('audio_en')) {
            $audioPaths['en'] = $request->file('audio_en')
                ->store('storybooks/pages/audio', 'public');
        }
        if ($request->hasFile('audio_hi')) {
            $audioPaths['hi'] = $request->file('audio_hi')
                ->store('storybooks/pages/audio', 'public');
        }
        
        if (!empty($audioPaths)) {
            $validated['audio_paths'] = $audioPaths;
        }

        $page = StorybookPage::create($validated);
        
        // Update storybook page count
        $storybook->updatePageCount();

        return redirect()->route('storybooks.pages.show', [$storybook, $page])
            ->with('success', 'Page created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Storybook $storybook, StorybookPage $page)
    {
        return Inertia::render('storybooks/pages/show', [
            'storybook' => $storybook,
            'page' => $page
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Storybook $storybook, StorybookPage $page)
    {
        return Inertia::render('storybooks/pages/edit', [
            'storybook' => $storybook,
            'page' => $page
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStorybookPageRequest $request, Storybook $storybook, StorybookPage $page)
    {
        $validated = $request->validated();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($page->image_path) {
                Storage::disk('public')->delete($page->image_path);
            }
            
            $validated['image_path'] = $request->file('image')
                ->store('storybooks/pages/images', 'public');
        }
        
        // Handle audio uploads
        $audioPaths = $page->audio_paths ?? [];
        if ($request->hasFile('audio_en')) {
            // Delete old audio
            if (isset($audioPaths['en'])) {
                Storage::disk('public')->delete($audioPaths['en']);
            }
            
            $audioPaths['en'] = $request->file('audio_en')
                ->store('storybooks/pages/audio', 'public');
        }
        if ($request->hasFile('audio_hi')) {
            // Delete old audio
            if (isset($audioPaths['hi'])) {
                Storage::disk('public')->delete($audioPaths['hi']);
            }
            
            $audioPaths['hi'] = $request->file('audio_hi')
                ->store('storybooks/pages/audio', 'public');
        }
        
        if (!empty($audioPaths)) {
            $validated['audio_paths'] = $audioPaths;
        }

        $page->update($validated);

        return redirect()->route('storybooks.pages.show', [$storybook, $page])
            ->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Storybook $storybook, StorybookPage $page)
    {
        // Delete associated files
        if ($page->image_path) {
            Storage::disk('public')->delete($page->image_path);
        }
        
        if ($page->audio_paths) {
            foreach ($page->audio_paths as $audioPath) {
                Storage::disk('public')->delete($audioPath);
            }
        }

        $page->delete();
        
        // Update storybook page count
        $storybook->updatePageCount();

        return redirect()->route('storybooks.pages.index', $storybook)
            ->with('success', 'Page deleted successfully.');
    }
}