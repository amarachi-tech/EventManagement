<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::all();
        $events = \App\Models\Event::all();

        foreach($users as $user){
            //for every user, generate a random event from 1 to 3
            $eventsToAttend = $events->random(rand(1, 3));
            foreach($eventsToAttend as $event){
                //for every eventToAttend (i.e, the assigned event), 
                //create the event for the user, using the user_id and event_id on the database 
                \App\Models\Attendee::create([
                    'user_id' => $user->id,
                    'event_id' => $event->id
                ]);
            }
        }
    }
}
