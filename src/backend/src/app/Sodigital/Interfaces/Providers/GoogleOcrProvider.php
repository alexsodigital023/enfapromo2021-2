<?php

namespace App\Sodigital\Interfaces\Providers;
use Storage;
use App\Sodigital\Interfaces\Providers\GoogleOcrProviderInterface;
use GoogleCloudVision\GoogleCloudVision;

class GoogleOcrProvider extends GoogleCloudVision implements GoogleOcrProviderInterface{
    protected $credencial;

    public function __construct(){

    }

    /**
     * Envía una petición a google para reconocimiento de texto
     * @param String $rq $headers
     * @return Object
     */
    public function checkInGoogle($rq,$headers,$api){
        $jsonDataEncoded = json_encode($rq);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $jsonDataEncoded );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }

    /**
     * Devuelve las credenciales de google
     *
     */
    public function getCredentials(){
        return $this->credencial;
    }

    /**
     * Establece credenciales para google
     *
     */
    public function setCredentials($credencial){
        $this->credencial = $credencial;
    }

}