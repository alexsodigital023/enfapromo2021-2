<?php

namespace App\Sodigital\Interfaces\Providers;
use App\Sodigital\Interfaces\Providers\GoogleOcrProviderInterface;
use GoogleCloudVision\GoogleCloudVision;

class GoogleOcrProvider extends GoogleCloudVision implements GoogleOcrProviderInterface{
    protected $credencial;

    public function __construct($rq,$headers){
    }

    //Envía una petición a google para reconocimiento de texto
    public function checkInGoogle($headers,$jsonDataEncoded){

    }

    //Devuelve las credenciales de google
    public function getCredentials(){
        return $this->credencial;
    }

    //Establece credenciales para google
    public function setCredentials($credencial){
        $this->credencial = $credencial;
    }

}