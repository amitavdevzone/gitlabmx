<?php

namespace App\Http\Controllers;

use App\Actions\Gitlab\IssueWebhookHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;

class GitlabWebhookController extends Controller
{
    private array $supportedEvents = [
        'issue' => IssueWebhookHandler::class,
    ];

    public function __invoke(Request $request): Response
    {
        if ($request->header('X-Gitlab-Token') != 'password') {
            throw new UnauthorizedException('Wrong token');
        }

        $payload = $request->all();

        if (! array_key_exists($payload['event_type'], $this->supportedEvents)) {
            return response([], status: 400);
        }

        app()->make(
            $this->supportedEvents[$payload['event_type']]
        )->handle($payload);

        return response([], status: 200);
    }
}
