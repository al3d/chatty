<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;

class StartController extends BaseController
{

    public function __invoke(Request $request)
    {
        $data = $this->validate($request, [
            'email' => ['required', 'email'],
        ]);

        return response()->json([
            'exists' => User::whereEmail($data['email'])->exists(),
        ]);
    }
}
