<?php

use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('belongs to a project', function () {
    // Arrange
    $issue = Issue::factory()
        ->for(Project::factory(), 'project')
        ->create();

    // Act & Assert
    expect($issue->project)->toBeInstanceOf(Project::class);
});

it('gets assigned to a user', function () {
    // Arrange
    $issue = Issue::factory()
        ->for(User::factory(), 'assigned')
        ->create();

    // Act & Assert
    expect($issue->assigned)->toBeInstanceOf(User::class);
});

it('has an author', function () {
    // Arrange
    $issue = Issue::factory()
        ->for(User::factory(), 'author')
        ->create();

    // Act & Assert
    expect($issue->author)->toBeInstanceOf(User::class);
});

it('has many comments', function () {
    // Arrange
    $issue = Issue::factory()
        ->has(
            Comment::factory()->count(3)->state(function (array $attributes) {
                return ['noteable_type' => 'Issue'];
            }),
            'comments'
        )
        ->create();

    // Act & Assert
    expect($issue->comments)->each->toBeInstanceOf(Comment::class);
});

it('has many time entries', function () {
    // Arrange
    $issue = Issue::factory()->has(TimeEntry::factory(3), 'time_entries')->create();

    // Act & Assert
    expect($issue->time_entries)->each->toBeInstanceOf(TimeEntry::class);
});
