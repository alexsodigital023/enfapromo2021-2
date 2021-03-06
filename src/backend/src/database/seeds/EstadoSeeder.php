<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    protected $_status=[
        [    
            "id"=>1,
            "name"=>"Aguascalientes"
        ],
        [    
            "id"=>2,
            "name"=>"Baja California"
        ],
        [    
            "id"=>3,
            "name"=>"Baja California Sur"
        ],
        [    
            "id"=>4,
            "name"=>"Campeche"
        ],
        [    
            "id"=>5,
            "name"=>"Chiapas"
        ],
        [    
            "id"=>6,
            "name"=>"Chihuahua"
        ],
        [    
            "id"=>7,
            "name"=>"Coahuila"
        ],
        [    
            "id"=>8,
            "name"=>"Colima"
        ],
        [    
            "id"=>9,
            "name"=>"Ciudad de México"
        ],
        [    
            "id"=>10,
            "name"=>"Durango"
        ],
        [    
            "id"=>11,
            "name"=>"Guanajuato"
        ],
        [    
            "id"=>12,
            "name"=>"Guerrero"
        ],
        [    
            "id"=>13,
            "name"=>"Hidalgo"
        ],
        [    
            "id"=>14,
            "name"=>"Jalisco"
        ],
        [    
            "id"=>15,
            "name"=>"Estado de México"
        ],
        [    
            "id"=>16,
            "name"=>"Michoacán"
        ],
        [    
            "id"=>17,
            "name"=>"Morelos"
        ],
        [    
            "id"=>18,
            "name"=>"Nayarit"
        ],
        [    
            "id"=>19,
            "name"=>"Nuevo León"
        ],
        [    
            "id"=>20,
            "name"=>"Oaxaca"
        ],
        [    
            "id"=>21,
            "name"=>"Puebla"
        ],
        [    
            "id"=>22,
            "name"=>"Querétaro"
        ],
        [    
            "id"=>23,
            "name"=>"Quintana Roo"
        ],
        [    
            "id"=>24,
            "name"=>"San Luis Potosí"
        ],
        [    
            "id"=>25,
            "name"=>"Sinaloa"
        ],
        [    
            "id"=>26,
            "name"=>"Sonora"
        ],
        [    
            "id"=>27,
            "name"=>"Tabasco"
        ],
        [    
            "id"=>28,
            "name"=>"Tamaulipas"
        ],
        [    
            "id"=>29,
            "name"=>"Tlaxcala"
        ],
        [    
            "id"=>30,
            "name"=>"Veracruz"
        ],
        [    
            "id"=>31,
            "name"=>"Yucatán"
        ],
        [    
            "id"=>32,
            "name"=>"Zacatecas"
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
            DB::table('cat_estado')->insert($st);
        }
    }
}
