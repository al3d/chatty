<?php

namespace App\Http\Controllers\Api\Channel;

use App\Http\Controllers\BaseController;
use App\Http\Resources\ChannelResource;
use App\Models\Channel;
use Illuminate\Http\Request;

class ShowController extends BaseController
{

    public function __invoke(Request $request, Channel $channel)
    {
        return new ChannelResource($channel);
    }

}
