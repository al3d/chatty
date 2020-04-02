<?php

namespace App\Models;

use App\Traits\CreatesNanoId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{

    use CreatesNanoId;
    use SoftDeletes;

    protected $table = 'messages';

    protected $perPage = 30;

    protected $fillable = [
        'channel_id',
        'user_id',
        'message',
    ];

    protected $guarded = [
        'uuid',
        'channel_id',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $with = [
        'channel',
        'user'
    ];

    public function channel(): Relations\BelongsTo
    {
        return $this->belongsTo(
            Channel::class,
            'channel_id'
        );
    }

    public function user(): Relations\BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function getIsDeletedAttribute(): bool
    {
        return $this->deleted_at !== null;
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
