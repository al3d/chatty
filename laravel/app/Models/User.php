<?php

namespace App\Models;

use App\Traits\CreatesNanoId;
use App\Support\Str;
use App\Support\Url as UrlHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class User extends Authenticatable
{

    use CreatesNanoId;
    use Notifiable;
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'last_login_at',
    ];

    protected $guarded = [
        'uuid',
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
            'user_id',
            'channel_id'
        );
    }

    public function messages(): Relations\HasMany
    {
        return $this->hasMany(
            Message::class,
            'user_id'
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

    public function routeNotificationForMail(Notification $notification)
    {
        return [$this->email => $this->name];
    }

    public function generateLoginMagicLink($remember = false, $expiryHours = 24)
    {
        $url = URL::temporarySignedRoute('magic_link', Carbon::now()->addHours($expiryHours), [
            'user' => $this,
            'remember' => $remember ? 'true' : 'false',
        ]);
        return Str::replaceFirst(
            URL::route('magic_link', [ 'user' => $this ]), // generating the same route without signed bits
            UrlHelper::frontend(sprintf('/login/magically/%s', $this->uuid)), // replacing with frontend. Hacky, but it'll do for now
            $url
        );
    }
}
