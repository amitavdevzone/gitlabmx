<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\GitlabService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->orderBy('name')
            ->paginate(10);

        return view('pages.user.index')
            ->with('users', $users);
    }

    public function create()
    {
        return view('pages.users.create');
    }

    public function store(Request $request, GitlabService $gitlabService)
    {
        $data = $request->validate([
            'username' => 'required|unique:users,gitlab_username',
        ]);

        $user = $gitlabService->createUserByUsername($data['username']);

        return redirect()
            ->route('users.show', ['user' => $user])
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('pages.users.show')
            ->with('user', $user);

    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'min:3',
        ]);

        User::where(['id' => $id])->update(['name' => $data['name']]);

        return redirect()
            ->route('users.show', ['user' => $id])
            ->with('success', 'User data updated');
    }
}
