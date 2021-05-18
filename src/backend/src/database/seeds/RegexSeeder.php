<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegexSeeder extends Seeder
{
    protected $_status=[
            [    
                "id"=>1,
                "product"=>"/.*CHOCO.ILK.*/",
                "import"=>"/(\d{1,9})+[.].{0,1}(\d{0,2})/",
                "active"=>1
            ],
            [    
                "id"=>2,
                "product"=>"/.*CHOCO.MILK.*\n[> 0-9a-zA-Z.]*/",
                "import"=>"/(\d{1,9})+[.].{0,1}(\d{0,2})/",
                "active"=>1
            ],
            [    
                "id"=>3,
                "product"=>"/.*CHOCO..ILK.*/",
                "import"=>"/(\d{1,9})+[.].{0,1}(\d{0,2})$/",
                "active"=>1
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
            DB::table('regex_rule')->insert($st);
        }
    }
}
