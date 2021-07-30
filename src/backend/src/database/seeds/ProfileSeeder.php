<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    protected $_status=[
            [
                "id"=>1,
                "name"=>"Concursante"
            ],
            [
                "id"=>2,
                "name"=>"Administrador",
                "assignable"=>1
            ],
            [
                "id"=>3,
                "name"=>"Operador",
                "assignable"=>1
            ]
        ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->_status as $st){
            DB::table('profile')->insert($st);
        }
    }
}
