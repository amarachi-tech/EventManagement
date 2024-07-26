<?php

namespace App\Providers;

use App\Models\Attendee;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Event;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('update-event', function($user, Event $event){
        //     return $user->id === $event->user_id;
        // });  

        // Gate::define('delete-attendee', function($user, Event $event, Attendee $attendee){
        //     return $user->id === $event->user_id || 
        //     $user->id === $attendee->user_id;
        // });
    }
}
