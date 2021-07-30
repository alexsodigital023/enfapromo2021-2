<?php

namespace App\Sodigital\Interfaces\Controllers;


interface ServiceControllerInterface{

    /**
     * Envía una petición a google para reconocimiento de texto
     *
     * @param String $ticket
     * @return object
     */
    public function checkInGoogle($Url);

    /**
     * Devuelve una instancia del manejador de google para OCR
     *
     * @return App\Sodigital\Interfaces\Provider\GoogleOcsProviderInterface
     */
    public function getGoogleOcrProvider();
}