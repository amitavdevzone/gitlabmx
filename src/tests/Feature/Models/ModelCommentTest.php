<?php

use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
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

test('comment belongs to a project', function () {
    // Arrange
    $comment = Comment::factory()
        ->for(Project::factory(), 'project')
        ->create();

    // Act & Assert
    expect($comment->project)->toBeInstanceOf(Project::class);
});

test('comment belongs to an issue', function () {
    // Arrange
    $comment = Comment::factory()
        ->for(Issue::factory(), 'issue')
        ->create();

    // Act & Assert
    expect($comment->issue)->toBeInstanceOf(Issue::class);
});
