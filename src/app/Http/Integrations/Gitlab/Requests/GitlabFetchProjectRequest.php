<?php

namespace App\Http\Integrations\Gitlab\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GitlabFetchProjectRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly int $projectID
    ) {
    }

    protected function defaultQuery(): array
    {
        return [
            'owned' => true,
            'sort' => 'desc',
            'order_by' => 'updated_at',
        ];
    }

    public function resolveEndpoint(): string
    {
        return "/projects/{$this->projectID}";
    }
}
