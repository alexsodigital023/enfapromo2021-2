<?php

namespace App\Sodigital\Interfaces\Providers;

interface GoogleOcsProviderInterface{

    /**
    * Envía una petición a google para reconocimiento de texto
     *
     * @param [type] $url
     * @return void
     */
    public function checkInGoogle($url);

    /**
     * Devuelve las credenciales de google
     *
     * @return void
     */
    public function getCredentials();

    /**
     * Establece coordenadas para google
     *
     * @return void
     */
    public function setCredentials();
}