<?php

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 5)->create()->each(function($user) {
            /** @var \App\User $user */
            $user->companies()->saveMany(factory(App\Company::class, 10)->make());
        });
    }
}
