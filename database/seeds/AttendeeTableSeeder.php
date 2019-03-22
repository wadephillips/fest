<?php

use App\Attendee;
use App\Event;
use Illuminate\Database\Seeder;

class AttendeeTableSeeder extends Seeder
{
  protected $event;

  /**
   * AttendeeTableSeeder constructor.
   * @param Event $event
   */
  public function __construct(Event $event)
  {
    $this->event = $event;
  }


  /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $three_day_attendees = factory(Attendee::class, 3)->create([
          'event_id' => $this->event->id,
          'modifiers' => [
              'payment' => [
                  'linens' => [
                      'value' => 1500,
                      'description' => 'Linens: Yes',
                  ],
                  'three_day_overnight_pass' => [
                      'value' => 30000,
                      'description' => 'Three Day Pass - Overnight Stay',
                  ],
              ],
              'meal' => [
                  'type' => [
                          'description' => 'Omnivore',
                  ],
              ],
          ],
          'total' => 31500,
      ]);

      $ear_attendees = factory(Attendee::class, 2)->create([
          'event_id' => $this->event->id,
          'modifiers' => [
              'payment' => [
                  'ear_training_day_only' => [
                      'value' => 25000,
                      'description' => 'Ear Training - 3 Day Pass - No Overnight Stay',
                  ],

                  'poca_tech_donation' => [
                      'value' => 500,
                      'description' => 'Donate $5 to POCA Tech',
                  ],
              ],
              'meal' => [
                  'type' => [
                          'description' => 'Vegetarian',
                  ],
              ],
              'other' => [
                  'other' => [
                      'value' => 'Teach me lots!',
                      'description' => 'Teach me lots!',
                  ],
              ],
          ],
          'total' => 25500,
      ]);

      $students = factory(Attendee::class, 4)->create([
          'event_id' => $this->event->id,
          'modifiers' => [
              'payment' => [
                  'linens' => [
                      'value' => 1500,
                      'description' => 'Linens: Yes',
                  ],
                  'student' => [
                      'value' => 12500,
                      'description' => 'Student - 3 Day Pass',
                  ],
              ],
              'meal' => [
                  'type' => [
                          'description' => 'Vegan',
                  ],
                  'other_food' => [
                      'description' => 'No meats!!',
                  ],
              ],
          ],
          'total' => 31500,
      ]);

      $fso_attendee = factory(Attendee::class)->create([
          'event_id' => $this->event->id,
          'modifiers' => [
              'payment' => [
                  'linens' => [
                      'value' => 0,
                      'description' => 'Linens: No',
                  ],
                  'fso_adult' => [
                      'value' => 10000,
                      'description' => 'Additional Family Member / Significant Other - Adult',
                  ],
                  'poca_tech_donation' => [
                      'value' => 500,
                      'description' => 'Donate $5 to POCA Tech',
                  ],
              ],
              'meal' => [
                  'type' => [
                          'description' => 'Omnivore',
                  ],
              ],
          ],
          'total' => 10500,
      ]);
    }
}
