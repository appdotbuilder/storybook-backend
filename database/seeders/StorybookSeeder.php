<?php

namespace Database\Seeders;

use App\Models\Storybook;
use App\Models\StorybookPage;
use Illuminate\Database\Seeder;

class StorybookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 published storybooks with pages
        Storybook::factory(10)
            ->published()
            ->create()
            ->each(function ($storybook) {
                // Create 5-8 pages per storybook
                $pageCount = random_int(5, 8);
                
                for ($i = 1; $i <= $pageCount; $i++) {
                    StorybookPage::factory()->create([
                        'storybook_id' => $storybook->id,
                        'page_number' => $i,
                    ]);
                }
                
                // Update page count
                $storybook->updatePageCount();
            });

        // Create 5 draft storybooks
        Storybook::factory(5)
            ->draft()
            ->create()
            ->each(function ($storybook) {
                // Create 2-4 pages per draft storybook
                $pageCount = random_int(2, 4);
                
                for ($i = 1; $i <= $pageCount; $i++) {
                    StorybookPage::factory()->create([
                        'storybook_id' => $storybook->id,
                        'page_number' => $i,
                    ]);
                }
                
                // Update page count
                $storybook->updatePageCount();
            });
    }
}