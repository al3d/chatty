<?php

namespace App\Http\Controllers\Api\Channel;

use App\Http\Controllers\BaseController;
use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DeleteController extends BaseController
{

    public function __invoke(Request $request, Channel $channel)
    {
        $this->authorize('delete', $channel);

        // soft-delete
        $channel->delete();

        return Response::noContent();
    }
}
