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
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
