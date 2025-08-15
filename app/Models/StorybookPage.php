<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\StorybookPage
 *
 * @property int $id
 * @property int $storybook_id
 * @property int $page_number
 * @property array $text_content
 * @property string|null $image_path
 * @property array|null $audio_paths
 * @property array|null $animation_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Storybook $storybook
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|StorybookPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StorybookPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StorybookPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|StorybookPage whereAnimationData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorybookPage whereAudioPaths($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorybookPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorybookPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorybookPage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorybookPage wherePageNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorybookPage whereStorybookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorybookPage whereTextContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorybookPage whereUpdatedAt($value)
 * @method static \Database\Factories\StorybookPageFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class StorybookPage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'storybook_id',
        'page_number',
        'text_content',
        'image_path',
        'audio_paths',
        'animation_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'text_content' => 'array',
        'audio_paths' => 'array',
        'animation_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the storybook that owns this page.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function storybook(): BelongsTo
    {
        return $this->belongsTo(Storybook::class);
    }

    /**
     * Get text content for a specific language.
     *
     * @param string $language
     * @return string|null
     */
    public function getTextForLanguage(string $language): ?string
    {
        return $this->text_content[$language] ?? null;
    }

    /**
     * Get audio path for a specific language.
     *
     * @param string $language
     * @return string|null
     */
    public function getAudioForLanguage(string $language): ?string
    {
        return $this->audio_paths[$language] ?? null;
    }
}