<?php

namespace App\Http\Controllers\Api\Channel\Message;

use App\Events\Message\Updated;
use App\Http\Controllers\BaseController;
use App\Http\Resources\MessageResource;
use App\Models\Channel;
use App\Models\Message;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{

    public function __invoke(Request $request, Channel $channel, Message $message)
    {
        $this->authorize('update', $message);

        $data = $this->validate($request, [
            'message' => ['required', 'string'],
        ]);

        if ($data['message'] !== $message->message) {
            $message->update([
                'message' => $data['message'],
            ]);
        }

        broadcast(new Updated($message))->toOthers();

        return (new MessageResource($message))
            ->additional([
                'channel' => $channel->name,
            ])
        ;
    }
}
