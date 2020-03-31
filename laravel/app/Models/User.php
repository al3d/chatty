<?php

namespace App\Models;

use App\Traits\CreatesNanoId;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use CreatesNanoId;
    use Notifiable;
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        // 'uuid',
        'name',
        'email',
        'password',
        // 'remember_token',
        'last_login_at',
        // 'created_at',
        // 'updated_at',
        // 'deleted_at',
    ];

    protected $guarded = [
        'uuid',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $dates = [
        'last_login_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function channels(): Relations\BelongsToMany
    {
        return $this->belongsToMany(
            Channel::class,
            'channel_users',
            'user_uuid',
            'channel_uuid'
        );
    }

    public function messages(): Relations\HasMany
    {
        return $this->hasMany(
            Message::class,
            'user_uuid',
            'uuid'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function getInitialsAttribute(): string
    {
        return Str::initials($this->name);
    }
}
