<?php

namespace App\Http\Controllers\Api\Channel\Message;

use App\Events\Message\Deleted;
use App\Http\Controllers\BaseController;
use App\Models\Channel;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DeleteController extends BaseController
{

    public function __invoke(Request $request, Channel $channel, Message $message)
    {
        $this->authorize('delete', $message);

        $uuid = $message->uuid;

        // soft-delete
        $message->delete();

        broadcast(new Deleted($uuid))->toOthers();

        return Response::noContent();
    }
}
