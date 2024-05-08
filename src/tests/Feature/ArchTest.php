<?php

arch('Enum folder only has enums')
    ->expect('App\Enums')
    ->toBeEnums();

arch('Traits folder only has traits')
    ->expect('App\Traits')
    ->toBeTraits();

arch('Services should end with service keyword')
    ->expect('App\Services')
    ->toHaveSuffix('Service');

arch('Events should end with event')
    ->expect('App\Events')
    ->toHaveSuffix('Event');

arch('Listeners should end with Listener')
    ->expect('App\Listeners')
    ->toHaveSuffix('Listener');

arch('Gitlab request should start with Gitlab')
    ->expect('App\Http\Integrations\Gitlab\Requests')
    ->toHavePrefix('Gitlab');

arch('Gitlab Webhook handlers ends with WebhookHandler')
    ->expect('App\Actions\Gitlab')
    ->toHaveSuffix('Handler');

arch('Gitlab Webhook handlers has handle method')
    ->expect('App\Actions\Gitlab')
    ->toHaveMethod('handle');
