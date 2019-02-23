<?php

use Illuminate\Database\Seeder;

class PresenterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Presenter::class, 50)->create();
    }
}
