<?php

namespace App\Sodigital\Interfaces\Providers;

use App\Sodigital\Interfaces\Providers\GoogleOcrProviderInterface;
use GoogleCloudVision\GoogleCloudVision;
use GoogleCloudVision\Request\AnnotateImageRequest;

class GoogleOcrProvider extends GoogleCloudVision implements GoogleOcrProviderInterface{
    protected $credencial;

    public function __construct(){

    }

    /**
     * Envía una petición a google para reconocimiento de texto
     * @param String $rq $headers
     * @return Object
     */
    public function checkInGoogle($url,$api){

        $features = "TEXT_DETECTION";
        $request = new AnnotateImageRequest();
        $request->setImageUri($url);
        $request->setFeature($features);

        $cv= new GoogleCloudVision([$request],$api);
        $response = $cv->annotate();
        if(is_array($response)&&$response["error"]){
            throw new \Exception($response["error"]->error->message);
        }
        foreach($response->responses as $r){
            if(!property_exists($r,"error")){
                return ($r->textAnnotations);
            }
        }
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