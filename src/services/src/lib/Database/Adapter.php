<?php

namespace Sodigital\Services\Database;

use Retrinko\Ini\IniFile;
use Illuminate\Database\Capsule\Manager as Base;
use Sodigital\Services\Model\Ticket;


class Adapter extends Base{
    function __construct(IniFile $config){
        parent::__construct();
        
        $this->addConnection([
            "driver" => $config->get("default","driver"),
            "host" => $config->get("default","host"),
            "database" =>  $config->get("default","database"),
            "username" =>  $config->get("default","username"),
            "password" =>  $config->get("default","password"),
            "port" =>  $config->get("default","port")
        ]);
        $this->setAsGlobal();
        $this->bootEloquent();
    }

    public function getRuleList(){
        $r=self::select('select * from regex_rule where active = ?',[1]);
        return $r;
    }

    public function getTickets($status=1){
        $r=self::select('select * from ticket where status_id = ?',[$status]);
        return $r;
    }

    public function updateTicket($id,$data){
        
        Ticket::where(["id"=>$id])->update($data);
    }
}