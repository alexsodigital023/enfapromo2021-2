<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class oauthClientSeeder extends Seeder
{
    protected $_status=[
            [
                "client_id"=>1,
                "client_secret"=>'$2y$10$Ff107q7i6H0F9UZdSRUt4OgPK3sSHVyjaBKzeIbmMP6S2Yl3T14ki',//prueba
                "redirect_uri"=>"/oauth/receivecode",
                "user_id"=>1,
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
            DB::table('oauth_clients')->insert($st);
        }
    }
}
