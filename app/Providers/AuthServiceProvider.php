<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Client;
use App\Models\Comment;
use App\Models\Delivery;
use App\Models\Estimate;
use App\Models\Issue;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Policies\ClientPolicy;
use App\Policies\CommentPolicy;
use App\Policies\DeliveryPolicy;
use App\Policies\EstimatePolicy;
use App\Policies\IssuePolicy;
use App\Policies\ProjectPolicy;
use App\Policies\TimeEntryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        Project::class => ProjectPolicy::class,
        Issue::class => IssuePolicy::class,
        Client::class => ClientPolicy::class,
        Comment::class => CommentPolicy::class,
        TimeEntry::class => TimeEntryPolicy::class,
        Delivery::class => DeliveryPolicy::class,
        Estimate::class => EstimatePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
