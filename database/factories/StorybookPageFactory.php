<?php

namespace Database\Factories;

use App\Models\Storybook;
use App\Models\StorybookPage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StorybookPage>
 */
class StorybookPageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\StorybookPage>
     */
    protected $model = StorybookPage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $englishTexts = [
            'Once upon a time, in a magical forest...',
            'The little elephant woke up early in the morning.',
            'She decided to explore the colorful meadow.',
            'Along the way, she met a friendly rabbit.',
            'Together, they discovered a hidden treasure.',
            'The sun was setting, painting the sky orange.',
            'They realized friendship was the greatest treasure.',
            'And they lived happily ever after.',
        ];

        $hindiTexts = [
            'एक बार की बात है, एक जादुई जंगल में...',
            'छोटा हाथी सुबह जल्दी उठ गया।',
            'उसने रंगबिरंगे मैदान का पता लगाने का फैसला किया।',
            'रास्ते में उसकी मुलाकात एक दोस्त खरगोश से हुई।',
            'साथ मिलकर उन्होंने एक छुपा हुआ खजाना खोजा।',
            'सूरज डूब रहा था, आसमान को नारंगी रंग से रंग रहा था।',
            'उन्हें एहसास हुआ कि दोस्ती सबसे बड़ा खजाना थी।',
            'और वे हमेशा खुश रहे।',
        ];

        return [
            'storybook_id' => Storybook::factory(),
            'page_number' => 1,
            'text_content' => [
                'en' => fake()->randomElement($englishTexts),
                'hi' => fake()->randomElement($hindiTexts),
            ],
            'image_path' => null,
            'audio_paths' => null,
            'animation_data' => null,
        ];
    }
}