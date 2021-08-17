<?php

namespace App\Sodigital\Services\Ocr;

use App\Mutators\Storage\Spaces;
use App\Sodigital\Interfaces\Providers\GoogleOcrProvider;


trait GoogleOcr
{
    use Spaces;

    /**
     * Envía una petición a google para reconocimiento de texto
     * @param String $url
     * @return Object
     */
    public function checkInGoogle($url)
    {
        $api = config('services.google.api');
        $provider = $this->getGoogleOcrProvider();
        return $provider->checkInGoogle($url,$api);
    }
    /**
     * Devuelve una instancia del manejador de google para OCR
     * @param String $rq,$headers
     */
    public function getGoogleOcrProvider()
    {
        //devolver una instancia del provider para google
        return new GoogleOcrProvider();

    }
}
