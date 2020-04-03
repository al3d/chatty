<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class ChannelUser extends Model
{

    public $timestamps = false;

    protected $table = 'channel_users';

    protected $fillable = [
        'channel_id',
        'user_id',
    ];

    protected $casts = [
        'channel_id' => 'integer',
        'user_id' => 'integer',
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
}
