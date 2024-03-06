<?php

namespace App\Http\Controllers;

use App\Events\UserLoggedInEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
            'remember' => 'sometimes',
        ]);

        $remember = $request->has('remember');
        $credentials = ['email' => $data['email'], 'password' => $data['password']];

        if (! Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages(['password' => 'Password is wrong']);
        }

        event(new UserLoggedInEvent(Auth::user()));

        return redirect(route('dashboard'))->with('success', 'Welcome');
    }
}
