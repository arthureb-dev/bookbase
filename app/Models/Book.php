<?php

namespace App\Models;

use App\Models\States\Book\BookState;
use App\Observers\BookObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStates\HasStates;

/**
 * 
 *
 * @property string $id
 * @property string $slug
 * @property int $user_id
 * @property string $title
 * @property string $author
 * @property string $description
 * @property string $publisher
 * @property string|null $isbn
 * @property string $category
 * @property string|null $cover_image
 * @property BookState $state
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int $page_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book orWhereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book orWhereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book wherePageCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book wherePublisher($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book withoutTrashed()
 * @mixin \Eloquent
 */
#[ObservedBy([BookObserver::class])]
class Book extends Model
{
    use HasFactory, HasStates, HasUlids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'description', 'author', 'publisher', 'category', 'isbn', 'published_at', 'cover_image', 'state'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'state' => BookState::class,
            'published_at' => 'date',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the book.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
