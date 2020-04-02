<?php

namespace App\Http\Controllers\Api\Channel;

use App\Http\Controllers\BaseController;
use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class LeaveController extends BaseController
{

    public function __invoke(Request $request, Channel $channel)
    {
        $user = $request->user();

        if ($channel->members->contains($user->id)) {
            $channel
                ->members()
                ->detach($user->id)
            ;
        }

        return Response::noContent();
    }
}
