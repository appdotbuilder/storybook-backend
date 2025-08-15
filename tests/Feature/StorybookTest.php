<?php

namespace Tests\Feature;

use App\Models\Storybook;
use App\Models\StorybookPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorybookTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Storage::fake('public');
    }

    public function test_can_view_welcome_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('welcome')
        );
    }

    public function test_can_view_public_storybooks()
    {
        Storybook::factory()->published()->create();
        Storybook::factory()->draft()->create(); // Should not appear in public view

        $response = $this->get('/storybooks');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('storybooks/index')
                ->where('storybooks.data', fn ($data) => count($data) === 1)
        );
    }

    public function test_authenticated_user_sees_all_storybooks()
    {
        $this->actingAs($this->user);
        
        Storybook::factory()->published()->create();
        Storybook::factory()->draft()->create();

        $response = $this->get('/storybooks');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('storybooks/index')
                ->has('storybooks.data', 2) // Both published and draft should show
        );
    }

    public function test_can_create_storybook()
    {
        $this->actingAs($this->user);

        $response = $this->post('/storybooks', [
            'title' => 'Test Storybook',
            'author' => 'Test Author',
            'languages' => ['en', 'hi'],
            'description' => 'Test description',
            'status' => 'draft',
            'age_group' => '3-5',
            'tags' => ['adventure', 'friendship'],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('storybooks', [
            'title' => 'Test Storybook',
            'author' => 'Test Author',
        ]);
    }

    public function test_can_upload_cover_image()
    {
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('cover.jpg');

        $response = $this->post('/storybooks', [
            'title' => 'Test Storybook',
            'author' => 'Test Author',
            'languages' => ['en'],
            'status' => 'draft',
            'cover_image' => $file,
        ]);

        $response->assertRedirect();
        
        $storybook = Storybook::where('title', 'Test Storybook')->first();
        $this->assertNotNull($storybook->cover_image);
        Storage::disk('public')->assertExists($storybook->cover_image);
    }

    public function test_can_add_pages_to_storybook()
    {
        $this->actingAs($this->user);

        $storybook = Storybook::factory()->create();

        $response = $this->post("/storybooks/{$storybook->id}/pages", [
            'page_number' => 1,
            'text_content' => [
                'en' => 'English text',
                'hi' => 'Hindi text',
            ],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('storybook_pages', [
            'storybook_id' => $storybook->id,
            'page_number' => 1,
        ]);
    }

    public function test_api_returns_published_storybooks()
    {
        Storybook::factory()->published()->create();
        Storybook::factory()->draft()->create();

        $response = $this->getJson('/api/storybooks');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    public function test_api_filters_by_language()
    {
        Storybook::factory()->published()->create(['languages' => ['en']]);
        Storybook::factory()->published()->create(['languages' => ['hi']]);
        Storybook::factory()->published()->create(['languages' => ['en', 'hi']]);

        $response = $this->getJson('/api/storybooks?language=en');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    public function test_api_returns_single_storybook()
    {
        $storybook = Storybook::factory()->published()->create();
        StorybookPage::factory()->create([
            'storybook_id' => $storybook->id,
            'page_number' => 1
        ]);

        $response = $this->getJson("/api/storybooks/{$storybook->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'title',
            'author',
            'pages'
        ]);
    }

    public function test_api_does_not_return_draft_storybooks()
    {
        $storybook = Storybook::factory()->draft()->create();

        $response = $this->getJson("/api/storybooks/{$storybook->id}");

        $response->assertStatus(404);
    }

    public function test_page_count_updates_automatically()
    {
        $storybook = Storybook::factory()->create(['page_count' => 0]);

        // Create 3 pages with different page numbers
        StorybookPage::factory()->create([
            'storybook_id' => $storybook->id,
            'page_number' => 1
        ]);
        StorybookPage::factory()->create([
            'storybook_id' => $storybook->id,
            'page_number' => 2
        ]);
        StorybookPage::factory()->create([
            'storybook_id' => $storybook->id,
            'page_number' => 3
        ]);

        $storybook->updatePageCount();

        $this->assertEquals(3, $storybook->fresh()->page_count);
    }
}