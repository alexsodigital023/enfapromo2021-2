<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegexSeeder extends Seeder
{
    protected $_status=[
            [    
                "id"=>1,
                "product"=>"/.*ca[lt1].{0,5}c.{0,5}[1tl][o0]se.*/im",
                "import"=>"/(\d{1,9})\.{0,1}(\d{0,2})$/im",
                "active"=>1
            ],
            [    
                "id"=>2,
                "product"=>"/.*ca[lt1].{0,5}c.{0,5}[1tl][o0]se.*/im",
                "import"=>"/(\d{1,9})\.{0,1}(\d{0,2}).*$/im",
                "active"=>1
            ],
            [    
                "id"=>3,
                "product"=>"/.* ca[l1t]c[ -].*/im",
                "import"=>"/(\d{1,9})\.{0,1}(\d{0,2})$/im",
                "active"=>1
            ],
            [    
                "id"=>4,
                "product"=>"/.*ca[lt1].{0,5}.{0,5}[1tl][o0]se.*/im",
                "import"=>"/(\d{1,9})\.{0,1}(\d{0,2})$/im",
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
