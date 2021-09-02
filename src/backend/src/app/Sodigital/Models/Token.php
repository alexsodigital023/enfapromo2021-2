<?php

namespace App\Sodigital\Models;

class Token{
    public $token;
    public $expiration;
    public $type;
    public $name;
    function __construct($token,$expiration=null,$type="Bearer"){
        $this->token=$token;
        if($expiration){
            $this->expiration=new \DateTime();
            $this->expiration->add(new \DateInterval(sprintf("PT%sS",$expiration)));
        }
        $this->type=$type;
    }
    public function saveInSession($name){
        return null;
        $this->name=$name;
        $_SESSION["app_enfarewards_token_".$name]=$this->token;
        $_SESSION["app_enfarewards_expirein_".$name]=$this->expiration?$this->expiration->getTimestamp()-time():null;
        $_SESSION["app_enfarewards_type_".$name]=$this->type;
    }
    public function expire(){
        return null;
        if($this->name){
            $_SESSION["app_enfarewards_token_".$this->name]=null;
            $_SESSION["app_enfarewards_expirein_".$this->name]=null;
            $_SESSION["app_enfarewards_type_".$this->name]=null;
        }
    }
    static function loadFromSession($name){
        return null;
        if($_SESSION["app_enfarewards_token_".$name]){
            try{
                $token= new Token(
                    $_SESSION["app_enfarewards_token_".$name],
                    $_SESSION["app_enfarewards_expirein_".$name],
                    $_SESSION["app_enfarewards_type_".$name]
                );
                $token->name=$name;
                return $token;
            }catch(\Exception $e){
                $_SESSION["app_enfarewards_token_".$name]=null;
                $_SESSION["app_enfarewards_expirein_".$name]=null;
                $_SESSION["app_enfarewards_type_".$name]=null;
            }
        }
    }
}