<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Storybook
 *
 * @property int $id
 * @property string $title
 * @property string $author
 * @property string|null $cover_image
 * @property array $languages
 * @property string|null $description
 * @property string $status
 * @property int $page_count
 * @property string|null $age_group
 * @property array|null $tags
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StorybookPage> $pages
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Storybook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Storybook newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Storybook query()
 * @method static \Illuminate\Database\Eloquent\Builder|Storybook whereAgeGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Storybook whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Storybook whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Storybook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Storybook whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Storybook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Storybook whereLanguages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Storybook wherePageCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Storybook whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Storybook whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Storybook whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Storybook whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Storybook published()
 * @method static \Database\Factories\StorybookFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Storybook extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'author',
        'cover_image',
        'languages',
        'description',
        'status',
        'page_count',
        'age_group',
        'tags',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'languages' => 'array',
        'tags' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the pages for this storybook.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages(): HasMany
    {
        return $this->hasMany(StorybookPage::class)->orderBy('page_number');
    }

    /**
     * Scope a query to only include published storybooks.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Update the page count based on actual pages.
     *
     * @return void
     */
    public function updatePageCount(): void
    {
        $this->update(['page_count' => $this->pages()->count()]);
    }
}