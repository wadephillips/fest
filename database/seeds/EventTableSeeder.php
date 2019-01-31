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
      //create 2 events
      factory(App\Event::class, 2)
          ->create()
          ->each(function ($event) {
            // create 20 breakouts for each event
            factory(App\Breakout::class, 20)->create([ 'event_id' => $event->id,])
                ->each(function ($breakout) use ($event) {
                  // assign 1 to 3 presenters to each breakout
                  $i = rand(1,3);
                  $ids = [];
                  for ($i; $i > 0; $i--) {
                    $ids[] = random_int(1,50);
                  }
                  $ids = array_unique($ids);

                  $breakout->presenters()->attach($ids);
                });
          });
    }
}
