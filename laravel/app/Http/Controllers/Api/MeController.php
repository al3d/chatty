<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class MeController extends BaseController
{

    public function __invoke(Request $request)
    {
        $user = $request->user();

        return (new UserResource($user))
            ->isOwner(true);
    }
}
