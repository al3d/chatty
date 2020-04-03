<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LogoutController extends BaseController
{

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('json.request.required');
        $this->middleware('throttle:60,1');
    }

    public function __invoke(Request $request)
    {
        return $this->logout($request);
    }
}
