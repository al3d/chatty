<?php

namespace App\Http\Controllers\Api\Channel;

use App\Http\Controllers\BaseController;
use App\Http\Resources\ChannelResource;
use App\Models\Channel;
use Illuminate\Http\Request;

class ListController extends BaseController
{

    public function __invoke(Request $request)
    {
        return ChannelResource::collection(Channel::all());
    }
}
