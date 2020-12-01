<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    protected $_status=[
        [
            "id"=>1,
            "name"=>"Nuevo"
        ],
        [
            "id"=>2,
            "name"=>"Rechazado"
        ],
        [
            "id"=>3,
            "name"=>"Aceptado"
        ],
        [
            "id"=>4,
            "name"=>"Leído"
        ],
        [
            "id"=>5,
            "name"=>"Error Producto"
        ],
        [
            "id"=>6,
            "name"=>"Error Importe"
        ],
        [
            "id"=>7,
            "name"=>"Error Archivo"
        ],
        [
            "id"=>8,
            "name"=>"Procesando archivo"
        ],
        [
            "id"=>9,
            "name"=>"Procesando Regex"
        ],
        [
            "id"=>10,
            "name"=>"Error Regex"
        ],
        [
            "id"=>11,
            "name"=>"Premiado"
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
            DB::table('cat_status')->insert($st);
        }
    }
}
