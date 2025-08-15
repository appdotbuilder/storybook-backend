<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Storybook;
use Illuminate\Http\Request;

class StorybookController extends Controller
{
    /**
     * Get published storybooks for mobile API.
     */
    public function index(Request $request)
    {
        $query = Storybook::published()->with('pages');
        
        // Filter by language if specified
        if ($request->has('language')) {
            $language = $request->input('language');
            $query->whereJsonContains('languages', $language);
        }
        
        // Filter by age group if specified
        if ($request->has('age_group')) {
            $query->where('age_group', $request->input('age_group'));
        }
        
        // Search by title or author
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ILIKE', "%{$search}%")
                  ->orWhere('author', 'ILIKE', "%{$search}%");
            });
        }

        $storybooks = $query->paginate(20);

        return response()->json($storybooks);
    }

    /**
     * Get a single storybook for mobile API.
     */
    public function show(Storybook $storybook, Request $request)
    {
        if ($storybook->status !== 'published') {
            return response()->json(['error' => 'Storybook not found'], 404);
        }
        
        $storybook->load('pages');
        
        // Filter content by language if specified
        if ($request->has('language')) {
            $language = $request->input('language');
            $filteredPages = $storybook->pages->map(function ($page) use ($language) {
                return [
                    'id' => $page->id,
                    'page_number' => $page->page_number,
                    'text_content' => $page->getTextForLanguage($language),
                    'image_path' => $page->image_path,
                    'audio_path' => $page->getAudioForLanguage($language),
                ];
            });
            $storybook->setRelation('pages', $filteredPages);
        }

        return response()->json($storybook);
    }
}