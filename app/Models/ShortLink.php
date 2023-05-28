<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Short link model.
 *
 * @property int $id
 * @property string $code
 * @property string $url
 * @property int $clicks
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property string $short_link_url
 * @property User $user
 */
class ShortLink extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'url',
        'clicks',
        'user_id',
    ];

    protected $appends = [
        'short_link_url',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the shortLink.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the short link url.
     */
    public function getShortLinkUrlAttribute(): string
    {
        return url('/sl/'.$this->code);
    }
}
