<?php

namespace App\Models;

use App\Traits\CreatesNanoId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class MagicLink extends Model
{

    use CreatesNanoId;

    protected $table = 'magic_link';

    protected $fillable = [
        // 'uuid',
        // 'user_uuid',
        'salt',
        'fingerprint',
        'accessed_at',
        // 'created_at',
        // 'updated_at',
    ];

    protected $guarded = [
        'uuid',
        'user_uuid',
        'created_at',
        'updated_at',
    ];

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
