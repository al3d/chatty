<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use App\Support\Str;

trait CreatesNanoId
{

    public static function bootCreatesNanoId()
    {
        static::creating(function (Model $model) {
            $model->uuid = Str::nanoId();
            $model->save();
        });

        static::replicating(function (Model $model) {
            if ($model->getAttribute('uuid')) {
                $model->uuid = Str::nanoId();
            }
        });
    }
}
