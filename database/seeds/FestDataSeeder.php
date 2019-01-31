<?php

use App\Presenter;
use Illuminate\Database\Seeder;

class FestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
          PresenterTableSeeder::class,
          EventTableSeeder::class,
        ]);
    }
}
