<?php

namespace App\Http\Controllers\Auth;

use App\Events\LoggedInViaMagicLink;
use App\Http\Controllers\BaseController;
use App\Support\Url;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class MagicLinkController extends BaseController
{

    public function __invoke(Request $request, User $user)
    {
        Auth::login($user, $request->get('remember') === 'true');

        Event::dispatch(new LoggedInViaMagicLink($user));

        return redirect(Url::frontend());
    }
}
