<?php

namespace Database\Factories;

use App\Models\Storybook;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Storybook>
 */
class StorybookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Storybook>
     */
    protected $model = Storybook::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'The Little Elephant\'s Adventure',
            'Rainbow Forest Tales',
            'Magic Garden Stories',
            'The Brave Little Mouse',
            'Journey to the Moon',
            'The Singing Bird',
            'Golden Mountain Quest',
            'The Kind Dragon',
            'Ocean Friends',
            'Starlight Adventures'
        ];

        $authors = [
            'Maya Sharma',
            'Rajesh Patel',
            'Priya Singh',
            'Arjun Kumar',
            'Kavya Reddy',
            'Suresh Gupta',
            'Anita Mehta',
            'Vikram Joshi'
        ];

        $ageGroups = ['3-5', '5-7', '7-9', '9-12'];
        $tags = [
            ['adventure', 'friendship'],
            ['magic', 'fantasy'],
            ['animals', 'nature'],
            ['courage', 'kindness'],
            ['space', 'exploration'],
            ['music', 'creativity'],
            ['family', 'love']
        ];

        return [
            'title' => fake()->randomElement($titles),
            'author' => fake()->randomElement($authors),
            'cover_image' => null,
            'languages' => fake()->randomElement([
                ['en'],
                ['hi'],
                ['en', 'hi']
            ]),
            'description' => fake()->paragraph(3),
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
            'page_count' => 0,
            'age_group' => fake()->randomElement($ageGroups),
            'tags' => fake()->randomElement($tags),
        ];
    }

    /**
     * Indicate that the storybook is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
        ]);
    }

    /**
     * Indicate that the storybook is in draft status.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
        ]);
    }
}