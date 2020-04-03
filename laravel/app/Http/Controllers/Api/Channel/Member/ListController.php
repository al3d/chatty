<?php

namespace App\Http\Controllers\Api\Channel\Member;

use App\Http\Controllers\BaseController;
use App\Http\Resources\UserResource;
use App\Models\Channel;
use Illuminate\Http\Request;

class ListController extends BaseController
{

    public function __invoke(Request $request, Channel $channel)
    {
        $collection = $channel
            ->members()
            ->get()
        ;

        return UserResource::collection($collection)
            ->additional([
                'channel' => $channel->name,
            ])
        ;
    }
}
