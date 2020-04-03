<?php

namespace App\Http\Controllers\Auth;

use App\Events\User\LoggedInViaMagicLink;
use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Response;

class MagicLinkController extends BaseController
{

    public function __construct()
    {
        $this->middleware('json.request.required');
        $this->middleware('guest');
        $this->middleware('throttle:60,1');
        $this->middleware('signed');
    }

    public function __invoke(Request $request, User $user)
    {
        Auth::login($user, $request->get('remember') === 'true');

        Event::dispatch(new LoggedInViaMagicLink($user));

        return Response::noContent();
    }
}
