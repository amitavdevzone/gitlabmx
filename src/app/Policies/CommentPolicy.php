<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class CommentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return Auth::check();
    }

    public function view(User $user, Comment $comment): bool
    {
        return Auth::check();
    }

    public function create(User $user): bool
    {
        return Auth::check();
    }

    public function update(User $user, Comment $comment): bool
    {
        return $user->id == $comment->author_id;
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $user->id == $comment->author_id;
    }

    public function restore(User $user, Comment $comment): bool
    {
    }

    public function forceDelete(User $user, Comment $comment): bool
    {
    }
}
