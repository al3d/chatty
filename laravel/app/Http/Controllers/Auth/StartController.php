<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class StartController extends BaseController
{

    public function __construct()
    {
        $this->middleware('json.request.required');
        $this->middleware('guest');
        $this->middleware('throttle:60,1');
    }

    public function __invoke(Request $request)
    {
        $data = $this->validate($request, [
            'email' => ['required', 'email'],
        ]);

        return Response::json([
            'exists' => User::whereEmail($data['email'])->exists(),
        ]);
    }
}
