<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    protected $_status=[
            [
                "id"=>1,
                "name"=>"Mantenimiento",
                "email"=>"carlos@sodigital.mx",
                "email_verified_at"=>"2011-10-08",
                "created_at"=>"2020-07-08",
                "password"=>'$2y$10$ovzW1imh09GS77zc3rKx6OnNOqu34b8frubGRrsflK5T4DDbIDx2a',//prueba
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
                "password"=>'$2y$10$ovzW1imh09GS77zc3rKx6OnNOqu34b8frubGRrsflK5T4DDbIDx2a',//baavieF8aejaech
                "oauth"=>1,
                "profile_id"=>3
            ],
            [
                "id"=>3,
                "name"=>"operador2",
                "email"=>"operador2@mailinator.com",
                "email_verified_at"=>"2011-10-11",
                "created_at"=>"2020-07-20",
                "password"=>'$2y$10$ovzW1imh09GS77zc3rKx6OnNOqu34b8frubGRrsflK5T4DDbIDx2a',//baavieF8aejaech
                "oauth"=>1,
                "profile_id"=>3
            ],
            [
                "id"=>4,
                "name"=>"Pedro Roldan",
                "email"=>"premios@playergroup.com.mx",
                "email_verified_at"=>"2011-10-11",
                "created_at"=>"2020-07-20",
                "password"=>'$2y$10$ovzW1imh09GS77zc3rKx6OnNOqu34b8frubGRrsflK5T4DDbIDx2a',//baavieF8aejaech
                "oauth"=>1,
                "backend"=>1,
                "profile_id"=>2
            ],
            [
                "id"=>5,
                "name"=>"Sebastian Gutierrez",
                "email"=>"promociones@playergroup.com.mx",
                "email_verified_at"=>"2011-10-11",
                "created_at"=>"2020-07-20",
                "password"=>'$2y$10$ovzW1imh09GS77zc3rKx6OnNOqu34b8frubGRrsflK5T4DDbIDx2a',//baavieF8aejaech
                "oauth"=>1,
                "backend"=>1,
                "profile_id"=>2
            ],
            [
                "id"=>6,
                "name"=>"Joaquin León",
                "email"=>"joaquin.leon@playergroup.com.mx",
                "email_verified_at"=>"2011-10-11",
                "created_at"=>"2020-07-20",
                "password"=>'$2y$10$ovzW1imh09GS77zc3rKx6OnNOqu34b8frubGRrsflK5T4DDbIDx2a',//baavieF8aejaech
                "oauth"=>1,
                "backend"=>1,
                "profile_id"=>2
            ],
            [
                "id"=>7,
                "name"=>"Bea Martínez",
                "email"=>"bea.martinez@playergroup.com.mx",
                "email_verified_at"=>"2011-10-11",
                "created_at"=>"2020-07-20",
                "password"=>'$2y$10$ovzW1imh09GS77zc3rKx6OnNOqu34b8frubGRrsflK5T4DDbIDx2a',//baavieF8aejaech
                "oauth"=>1,
                "backend"=>1,
                "profile_id"=>2
            ],
        ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->_status as $st){
            DB::table('users')->insert($st);
        }
    }
}
