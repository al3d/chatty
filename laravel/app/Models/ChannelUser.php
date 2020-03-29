<?php

namespace App\Models;

use App\Traits\CreatesNanoId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class ChannelUser extends Model
{

    use CreatesNanoId;

    protected $table = 'channel_users';

    protected $timestamps = false;

    protected $fillable = [
        // 'uuid',
        'channel_uuid',
        'user_uuid',
    ];

    protected $guarded = [
        'uuid',
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
}
