<?php

namespace App\Sodigital\Services\Regex;

use App\Ticket;
use App\Rule;

class Regex{

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

    public function processTicket(Ticket &$ticket){
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
                        try{
                        $importe+=floatval($p[1][$i])+(floatval($p[2][$i])?floatval($p[2][$i])/100:0);
                        }catch(\Exception $e){
                            
                        }
                    }
                }
                if($importe >= 39.9){
                    $status = 3;
                    $desc="Ok";
                    break;
                }
            }
        }

        $ticket->status_id=$status;
        $ticket->status_desc=$desc;
        $ticket->rule_id=$ruleid;
        $ticket->product=count($productos);
        $ticket->products_find=json_encode($productos);
        $ticket->import=$importe;
        $ticket->save();
    }

    public function __get($name){
        switch($name){
            case "ruleList":
                $this->ruleList=Rule::get();
                return $this->ruleList;
            break;
            default:
                return $this->$name;
        }
    }
}