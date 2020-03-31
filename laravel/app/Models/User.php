<?php

namespace App\Models;

use App\Traits\CreatesNanoId;
use App\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class User extends Authenticatable
{

    const SALT_LENGTH = 60;

    use CreatesNanoId;
    use Notifiable;
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        // 'uuid',
        'name',
        'email',
        'password',
        // 'salt',
        // 'remember_token',
        'last_login_at',
        // 'created_at',
        // 'updated_at',
        // 'deleted_at',
    ];

    protected $guarded = [
        'uuid',
        'salt',
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

    public function getColourAttribute(): string
    {
        return Str::hexColor($this->name);
    }

    public function getLoginHashAttribute(): string
    {
        return hash('sha256', $this->uuid . $this->salt);
    }

    public function scopeWhereLoginHash(Builder $query, $hash): Builder
    {
        return $query
            ->whereRaw('SHA2(CONCAT(uuid, salt)) = ?', [$hash]);
    }

    public function routeNotificationForMail(Notification $notification)
    {
        return [$this->email => $this->name];
    }

    public static function generateSalt(): string
    {
        return Str::random(static::SALT_LENGTH);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->salt = static::generateSalt();
        });
    }
}
