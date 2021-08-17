<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiendaSeeder extends Seeder
{
    protected $_status=[
        [    
            "id"=>1,
            "name"=>"Bodega Aurrerá"
        ],
        [    
            "id"=>2,
            "name"=>"Casa Ley"
        ],
        [    
            "id"=>3,
            "name"=>"Chedraui"
        ],
        [    
            "id"=>4,
            "name"=>"City Club"
        ],
        [    
            "id"=>5,
            "name"=>"City Market"
        ],
        [    
            "id"=>6,
            "name"=>"Comercial Mexicana"
        ],
        [    
            "id"=>7,
            "name"=>"Costco"
        ],
        [    
            "id"=>8,
            "name"=>"Farmacias Guadalajara"
        ],
        [    
            "id"=>9,
            "name"=>"Farmacias San Pablo"
        ],
        [    
            "id"=>10,
            "name"=>"Fresko"
        ],
        [    
            "id"=>11,
            "name"=>"H-E-B"
        ],
        [    
            "id"=>12,
            "name"=>"La Comer"
        ],
        [    
            "id"=>13,
            "name"=>"Sam's"
        ],
        [    
            "id"=>14,
            "name"=>"Smart"
        ],
        [    
            "id"=>15,
            "name"=>"Soriana"
        ],
        [    
            "id"=>16,
            "name"=>"Superama"
        ],
        [    
            "id"=>17,
            "name"=>"Walmart Supercenter"
        ],
        [    
            "id"=>18,
            "name"=>"Otro"
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
            DB::table('cat_tienda')->insert($st);
        }
    }
}
