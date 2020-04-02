<?php

namespace App\Http\Controllers\Api\Channel\Message;

use App\Http\Controllers\BaseController;
use App\Http\Resources\MessageResource;
use App\Models\Channel;
use App\Models\Message;
use Illuminate\Http\Request;

class ShowController extends BaseController
{

    public function __invoke(Request $request, Channel $channel, Message $message)
    {
        return (new MessageResource($message))
            ->additional([
                'channel' => $channel->name,
            ])
        ;
    }
}
