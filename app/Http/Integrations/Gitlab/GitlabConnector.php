<?php

namespace App\Http\Integrations\Gitlab;

use App\Services\GitlabService;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class GitlabConnector extends Connector
{
    use AcceptsJson;

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return config('services.gitlab.base_url');
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        $gitlabService = app()->make(GitlabService::class);
        return new TokenAuthenticator($gitlabService->getAccessToken());
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        return [];
    }

    /**
     * Default HTTP client options
     */
    protected function defaultConfig(): array
    {
        return [];
    }
}
