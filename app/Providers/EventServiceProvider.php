<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\Ethics\PartnerRegistrationInitiated' => [
            'App\Listeners\Ethics\PartnerRegistrationInitiatedListener',
        ],
        'App\Events\Ethics\PublicPartnerRegistrationInitiated' => [
            'App\Listeners\Ethics\PublicPartnerRegistrationInitiatedListener',
        ],
        'App\Events\Ethics\PartnerQuestionnaireSubmitted' => [
            'App\Listeners\Ethics\PartnerQuestionnaireSubmittedListener',
        ],
        'App\Events\Ethics\PmApproved' => [
            'App\Listeners\Ethics\PmApprovedListener',
        ],
        'App\Events\Ethics\ComplianceDecision' => [
            'App\Listeners\Ethics\ComplianceDecisionListener',
        ],
        'App\Events\Ethics\PartnerRegistered' => [
            'App\Listeners\Ethics\PartnerRegisteredListener',
        ],
        'App\Events\Ethics\PartnerBlacklisted' => [
            'App\Listeners\Ethics\PartnerBlacklistedListener',
        ],
        'App\Events\Ethics\PartnerEnlisted' => [
            'App\Listeners\Ethics\PartnerEnlistedListener',
        ],
        'App\Events\Ethics\PartnerRenewed' => [
            'App\Listeners\Ethics\PartnerRenewedListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
