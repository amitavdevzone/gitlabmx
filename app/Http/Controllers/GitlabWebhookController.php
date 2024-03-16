<?php

namespace App\Http\Controllers;

use App\Actions\Gitlab\CommentWebhookHandler;
use App\Actions\Gitlab\IssueWebhookHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GitlabWebhookController extends Controller
{
    private array $supportedEvents = [
        'issue' => IssueWebhookHandler::class,
        'note' => CommentWebhookHandler::class,
    ];

    public function __invoke(Request $request): Response
    {
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
