<?php

use App\Http\Integrations\Gitlab\Requests\GitlabFetchUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('creates the suer with correct data', function () {
    // Arrange
    $sampleData = json_decode(
        file_get_contents(__DIR__.'/../../Fixtures/gitlabuser.json'), true
    );
    MockClient::global([
        GitlabFetchUser::class => MockResponse::make(body: $sampleData, status: 200),
    ]);

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    post(route('users.store'), ['username' => 'amitav.roy']);

    $this->assertDatabaseCount('users', 2);
});
