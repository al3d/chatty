<?php

namespace App\Http\Controllers\Api\Channel\Message;

use App\Http\Controllers\BaseController;
use App\Http\Resources\ChannelResource;
use App\Http\Resources\MessageResource;
use App\Models\Channel;
use Illuminate\Http\Request;

class ListController extends BaseController
{

    public function __invoke(Request $request, Channel $channel)
    {
        $collection = $channel
            ->messagesListedByNewestFirst()
            ->paginate()
        ;

        return MessageResource::collection($collection)
            ->additional([
                'channel' => new ChannelResource($channel),
            ])
        ;
    }
}
