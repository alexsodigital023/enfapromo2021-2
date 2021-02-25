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
                "password"=>Hash::make("ghRWRJ4HJfpVNNRjvhqzcHq3M"),
                "oauth"=>1,
                "backend"=>1,
                "profile_id"=>2
            ],
            [
                "name"=>"Joaquin Leon",
                "email"=>"premios@playergroup.com.mx",
                "email_verified_at"=>"2011-10-08",
                "created_at"=>"2020-07-08",
                "password"=>Hash::make("ghRWRJ4HJfpVNNRjvhqzcHq3M"),
                "oauth"=>1,
                "backend"=>1,
                "profile_id"=>2
            ],
            [
                "name"=>"Sammir Madrid",
                "email"=>"promocion@playergroup.com.mx",
                "email_verified_at"=>"2011-10-08",
                "created_at"=>"2020-07-08",
                "password"=>Hash::make("ghRWRJ4HJfpVNNRjvhqzcHq3M"),
                "oauth"=>1,
                "backend"=>1,
                "profile_id"=>2
            ],
            [
                "name"=>"Rachel Mendoza",
                "email"=>"Rachel.m@playergroup.com.mx",
                "email_verified_at"=>"2011-10-08",
                "created_at"=>"2020-07-08",
                "password"=>Hash::make("ghRWRJ4HJfpVNNRjvhqzcHq3M"),
                "oauth"=>1,
                "backend"=>1,
                "profile_id"=>2
            ]
        ] as $st){
            DB::table('users')->insert($st);
        }
    }
}