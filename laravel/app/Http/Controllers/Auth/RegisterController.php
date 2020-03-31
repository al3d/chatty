<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Notifications\RegisteredNotification;
use App\Support\Str;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{

    use RegistersUsers;

    protected $generatedPassword;

    public function __invoke(Request $request)
    {
        $this->generatedPassword = Str::generatePassword();
        return $this->register($request);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($this->generatedPassword),
            'last_login_at' => Carbon::now(),
        ]);
    }

    protected function registered(Request $request, User $user)
    {
        $user->notify(new RegisteredNotification($this->generatedPassword));
    }
}
