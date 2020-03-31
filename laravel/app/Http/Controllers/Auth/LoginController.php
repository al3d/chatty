<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Notifications\MagicLinkNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class LoginController extends BaseController
{

    use AuthenticatesUsers;

    public function __invoke(Request $request)
    {
        if ($request->filled('magic_link')) {
            return $this->magicLink($request);
        }

        return $this->login($request);
    }

    protected function magicLink(Request $request)
    {
        if (!$user = User::whereEmail($request->get('email'))->first()) {
            return $this->sendFailedLoginResponse($request);
        }

        $magicLink = URL::temporarySignedRoute('magic_link', Carbon::now()->addHours(24), [
            'userHash' => $user->login_hash,
            'remember' => $request->filled('magic_link') ? 'true' : 'false',
        ]);

        $user->notify(new MagicLinkNotification($magicLink));

        return response('', 204);
    }
}
