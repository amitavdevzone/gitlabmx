<?php

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('comment belongs to a user', function () {
    // Arrange
    $comment = Comment::factory()
        ->for(User::factory(), 'author')
        ->create();

    // Act & Assert
    expect($comment->author)->toBeInstanceOf(User::class);
});
