<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach([
            [
                "id"=>1,
                "name"=>"Mantenimiento",
                "email"=>"prueba@sodigital.mx",
                "email_verified_at"=>"2011-10-08",
                "created_at"=>"2020-07-08",
                "password"=>Hash::make("prueba"),
                "oauth"=>1,
                "backend"=>1,
                "profile_id"=>2
            ],
            [
                "id"=>2,
                "name"=>"operador1",
                "email"=>"operador1@mailinator.com",
                "email_verified_at"=>"2011-10-08",
                "created_at"=>"2020-07-08",
                "password"=>Hash::make("prueba"),
                "oauth"=>1,
                "profile_id"=>3
            ],
            [
                "id"=>3,
                "name"=>"operador2",
                "email"=>"operador2@mailinator.com",
                "email_verified_at"=>"2011-10-11",
                "created_at"=>"2020-07-20",
                "password"=>Hash::make("prueba"),
                "oauth"=>1,
                "profile_id"=>3
            ],
            [
                "id"=>4,
                "name"=>"Pedro Roldan",
                "email"=>"operador3@mailinator.com",
                "email_verified_at"=>"2011-10-11",
                "created_at"=>"2020-07-20",
                "password"=>Hash::make("prueba"),
                "oauth"=>1,
                "backend"=>1,
                "profile_id"=>2
            ],
            [
                "id"=>5,
                "name"=>"Sebastian Gutierrez",
                "email"=>"operador4@mailinator.com",
                "email_verified_at"=>"2011-10-11",
                "created_at"=>"2020-07-20",
                "password"=>Hash::make("prueba"),
                "oauth"=>1,
                "backend"=>1,
                "profile_id"=>2
            ],
            [
                "id"=>6,
                "name"=>"Joaquin León",
                "email"=>"operador5@mailinator.com",
                "email_verified_at"=>"2011-10-11",
                "created_at"=>"2020-07-20",
                "password"=>Hash::make("prueba"),
                "oauth"=>1,
                "backend"=>1,
                "profile_id"=>2
            ],
            [
                "id"=>7,
                "name"=>"Bea Martínez",
                "email"=>"operador6@mailinator.com",
                "email_verified_at"=>"2011-10-11",
                "created_at"=>"2020-07-20",
                "password"=>Hash::make("prueba"),
                "oauth"=>1,
                "backend"=>1,
                "profile_id"=>2
            ],
        ] as $st){
            DB::table('users')->insert($st);
        }
    }
}
