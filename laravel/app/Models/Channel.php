<?php

namespace App\Models;

use App\Traits\CreatesNanoId;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends Model
{

    use CreatesNanoId;
    use SoftDeletes;

    protected $table = 'channels';

    protected $fillable = [
        'name',
        'description',
        'creator_id',
    ];

    protected $guarded = [
        'uuid',
        'creator_id',
        'is_deleteable',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $attributes = [
        'is_deleteable' => true,
    ];

    protected $casts = [
        'creator_id' => 'integer',
        'is_deleteable' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $with = [
        'creator',
        'members',
    ];

    public function creator(): Relations\BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'creator_id'
        );
    }

    public function messages(): Relations\HasMany
    {
        return $this
            ->hasMany(
                Message::class,
                'channel_id'
            )
            ->withTrashed()
        ;
    }

    public function messagesListedByNewestFirst()
    {
        return $this
            ->messages()
            ->latest();
    }

    public function members(): Relations\BelongsToMany
    {
        return $this
            ->belongsToMany(
                User::class,
                'channel_users',
                'channel_id',
                'user_id'
            )
            ->orderByDesc('users.last_login_at')
            ->orderByDesc('users.created_at')
        ;
    }

    public function getRouteKeyName(): string
    {
        return 'name';
    }
}
