<?php

namespace App\Models;

use App\Models\States\Book\BookState;
use App\Observers\BookObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditTrait;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\ModelStates\HasStates;

/**
 * @property string $id
 * @property string $slug
 * @property int $user_id
 * @property string $title
 * @property string $author
 * @property string $description
 * @property string $publisher
 * @property string $isbn
 * @property string $category
 * @property string|null $cover_image
 * @property BookState $state
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int $page_count
 * @property \Illuminate\Support\Carbon|null $checked_out_at
 * @property \Illuminate\Support\Carbon|null $due_date
 * @property int|null $checked_out_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User|null $checkedOutBy
 * @property-read mixed $average_rating
 * @property-read mixed $review_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read \App\Models\User $user
 *
 * @method static \Database\Factories\BookFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book orWhereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book orWhereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereCheckedOutAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereCheckedOutBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereDueDate($value)
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
 *
 * @mixin \Eloquent
 */
#[ObservedBy([BookObserver::class])]
class Book extends Model implements AuditableContract
{
    use AuditTrait, HasFactory, HasStates, HasUlids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'description', 'author', 'publisher', 'category', 'isbn', 'published_at', 'cover_image', 'state', 'page_count', 'checked_out_at', 'due_date', 'checked_out_by'];

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
            'due_date' => 'datetime',
            'checked_out_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the book.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reviews for the book.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the user that checked out the book.
     */
    public function checkedOutBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_out_by');
    }

    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }
}
