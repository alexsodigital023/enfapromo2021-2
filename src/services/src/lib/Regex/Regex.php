<?php

namespace Sodigital\Services\Regex;


use Sodigital\Services\Database\Adapter;

class Regex{

    protected $_db;

    function __construct(Adapter $db)
    {
        $this->_db=$db;
    }
    public function run(){
        $tickets=$this->_db->getTickets(4);

        foreach($tickets as $t){


            try{
                $this->_db->updateTicket($t->id,["status_id"=>9]);
                $this->processTicket($t);
            }catch(\Exception $e){
                $this->_db->updateTicket($t->id,["status_id"=>10]);
            }
        }
    }

    public function processTicket($ticket){
        $productos=[];
        $importe=0;
        $status = 5;
        $ruleid=null;
        $desc="Producto no encontrado";
        foreach($this->ruleList as $rule){
            $m=[];
            preg_match_all($rule->product,$ticket->data,$m);

            if(count($m[0])){
                $status = 6;
                $ruleid = $rule->id;
                $desc="Importe inferior o no encontrado";
                foreach($m[0] as $producto){
                    $productos[]=$producto;
                    $p=[];
                    preg_match_all($rule->import,$producto,$p);
                    foreach($p[0] as $i=>$imp){
                        $importe+=floatval($p[1][$i])+(floatval($p[2][$i])?floatval($p[2][$i])/100:0);
                    }
                }
                if($importe >= 39.9){
                    $status = 3;
                    $desc="Ok";
                    break;
                }
            }
        }

        $this->_db->updateTicket($ticket->id,[
            "status_id"=>$status,
            "status_desc"=>$desc,
            "rule_id"=>$ruleid,
            "product"=>count($productos),
            "products_find"=>json_encode($productos),
            "import"=>$importe
            ]);
    }

    public function __get($name){
        switch($name){
            case "ruleList":
                $this->ruleList=$this->_db->getRuleList();
                return $this->ruleList;
            break;
            default:
                return $this->$name;
        }
    }
}