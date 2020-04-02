<?php

namespace App\Http\Controllers\Api\Channel;

use App\Http\Controllers\BaseController;
use App\Http\Resources\ChannelResource;
use App\Models\Channel;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{

    public function __invoke(Request $request, Channel $channel)
    {
        $this->authorize('update', $channel);

        $data = $this->validate($request, [
            'description' => ['required', 'string', 'max:255'],
        ]);

        $channel->update($data);

        return new ChannelResource($channel);
    }
}
