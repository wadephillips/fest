<?php

use Illuminate\Database\Seeder;


class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(App\Event::class, 2)
          ->create()
          ->each(function ($event) {
            factory(App\Breakout::class, 20)->create([ 'event_id' => $event->id,])
                ->each(function ($breakout) use ($event) {
                  //todo figure out how to assign 1 to 3 presenters here
                });
          });
    }
}
