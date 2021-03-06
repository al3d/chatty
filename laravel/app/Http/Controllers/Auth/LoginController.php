<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Notifications\MagicLinkNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class LoginController extends BaseController
{

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('json.request.required');
        $this->middleware('guest');
        $this->middleware('throttle:60,1');
    }

    public function __invoke(Request $request)
    {
        if ($request->get('magic_link')) {
            return $this->magicLink($request);
        }

        return $this->login($request);
    }

    protected function magicLink(Request $request)
    {
        if (!$user = User::whereEmail($request->get('email'))->first()) {
            return $this->sendFailedLoginResponse($request);
        }

        $magicLink = $user->generateLoginMagicLink($request->get('remember'));

        $user->notify(new MagicLinkNotification($magicLink));

        return Response::noContent();
    }
}
