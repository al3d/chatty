<?php

namespace App\Http\Controllers\Api\Channel;

use App\Events\User\JoinedChannel;
use App\Http\Controllers\BaseController;
use App\Http\Resources\ChannelResource;
use App\Models\Channel;
use App\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;

class CreateController extends BaseController
{

    public function __invoke(Request $request)
    {
        $this->authorize('create', Channel::class);

        $data = Validator::make([
            'name' => Str::slug($request->get('name')),
            'description' => $request->get('description'),
        ], [
            'name' => ['required', 'alpha_dash', 'max:20', 'unique:channels'],
            'description' => ['required', 'string', 'max:255'],
        ])->validate();

        $channel = $request
            ->user()
            ->channels()
            ->create($data)
        ;

        Event::dispatch(new JoinedChannel($request->user(), $channel));

        return new ChannelResource($channel);
    }
}
