<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StatusSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(TiendaSeeder::class);
        $this->call(ProfileSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RegexSeeder::class);
        $this->call(oauthClientSeeder::class);
        //$this->call(TicketSeeder::class);
    }
}
