<?php

use App\Models\Client;
use App\Models\Issue;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('time entry belongs to a user', function () {
    $timeEntry = TimeEntry::factory()
        ->for(User::factory())
        ->create();

    expect($timeEntry->user)->toBeInstanceOf(User::class);
});

test('time entry belongs to a client', function () {
    $timeEntry = TimeEntry::factory()
        ->for(Client::factory())
        ->create();

    expect($timeEntry->client)->toBeInstanceOf(Client::class);
});

test('time entry belongs to a project', function () {
    $timeEntry = TimeEntry::factory()
        ->for(Project::factory())
        ->create();

    expect($timeEntry->project)->toBeInstanceOf(Project::class);
});

test('time entry belongs to an issue', function () {
    $timeEntry = TimeEntry::factory()
        ->for(Issue::factory())
        ->create();

    expect($timeEntry->issue)->toBeInstanceOf(Issue::class);
});
