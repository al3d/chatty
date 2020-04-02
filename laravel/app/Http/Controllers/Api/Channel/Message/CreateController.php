<?php

namespace App\Http\Controllers\Api\Channel\Message;

use App\Events\User\JoinedChannel;
use App\Events\Message\Created;
use App\Http\Controllers\BaseController;
use App\Http\Resources\MessageResource;
use App\Models\Channel;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class CreateController extends BaseController
{

    public function __invoke(Request $request, Channel $channel)
    {
        $this->authorize('create', Message::class);

        $data = $this->validate($request, [
            'message' => ['required', 'string'],
        ]);

        $message = $channel
            ->messages()
            ->create([
                'message' => $data['message'],
                'user_id' => $request->user()->id,
            ])
        ;

        Event::dispatch(new JoinedChannel($request->user(), $channel));

        broadcast(new Created($message))->toOthers();

        return (new MessageResource($message))
            ->additional([
                'channel' => $channel->name,
            ])
        ;
    }
}
