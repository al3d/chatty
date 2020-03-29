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

    protected $fillable = [
        // 'uuid',
        // 'channel_uuid',
        // 'user_uuid',
        'message',
        // 'created_at',
        // 'updated_at',
        // 'deleted_at',
    ];

    protected $guarded = [
        'uuid',
        'channel_uuid',
        'user_uuid',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function channel(): Relations\BelongsTo
    {
        return $this->belongsTo(
            Channel::class,
            'channel_uuid',
            'uuid'
        );
    }

    public function user(): Relations\BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_uuid',
            'uuid'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
