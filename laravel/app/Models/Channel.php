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
        // 'uuid',
        'name',
        'description',
        // 'creator_uuid',
        // 'created_at',
        // 'updated_at',
        // 'deleted_at',
    ];

    protected $guarded = [
        'uuid',
        'creator_uuid',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function creator(): Relations\BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'creator_uuid',
            'uuid'
        );
    }

    public function messages(): Relations\HasMany
    {
        return $this->hasMany(
            Message::class,
            'channel_uuid',
            'uuid'
        );
    }

    public function members(): Relations\HasMany
    {
        return $this->hasMany(
            ChannelUser::class,
            'channel_uuid',
            'uuid'
        );
    }

    // @todo - check this is the best way to do this - seems hacky
    public function scopeOrderByLatestMessages(Builder $query): Builder
    {
        return $query
            ->leftJoin(
                'messages',
                'channels.name',
                '=',
                'messages.channel'
            )
            ->orderByDesc('messages.created_at')
            ->select('channels.*');
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
