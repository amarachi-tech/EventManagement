<?php

namespace App\Console\Commands;

use App\Notifications\EventReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SendEventRemiders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:name';
    protected $signature = 'SendEventReminders';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sends notification to all events attendees that event starts soon';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return Command::SUCCESS;
        $events = \App\Models\Event::with('attendee.user')
            ->whereBetween('start_time', [now(), now()->addDay()])
            ->get();

        $eventCount = $events->count();
        $eventLabel = Str::plural('event', $eventCount);
        $this->info("Found {$eventCount} {$eventLabel}");
        //get a list of all the attendee
        $events->each(
            fn($event) =>$event->attendee->each(
                fn($attendee) => $attendee->user->notify(
                    new EventReminderNotification(
                        $event
                    )
                )
                )
            );
        $this->info('Reminder notifications sent successfully!');
    }
}
