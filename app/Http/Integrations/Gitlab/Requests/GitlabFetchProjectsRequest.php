<?php

namespace App\Http\Integrations\Gitlab\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GitlabFetchProjectsRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    protected function defaultQuery(): array
    {
        return [
            'owned' => true,
            'sort' => 'desc',
            'order_by' => 'updated_at',
        ];
    }


    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/projects';
    }
}
