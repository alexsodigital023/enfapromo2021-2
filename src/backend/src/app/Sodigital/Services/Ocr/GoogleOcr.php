<?php

namespace App\Sodigital\Services\Ocr;

use App\Mutators\Storage\Spaces;
use App\Sodigital\Interfaces\Providers\GoogleOcrProvider;
use GoogleCloudVision\Request\AnnotateImageRequest;
use Storage;


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
        $features = "TEXT_DETECTION";
        $request = new AnnotateImageRequest();
        $request->setImageUri($url);
        $request->setFeature($features);
        $api = config('services.google.api');
        $rq = array(
            "requests" => $request
        );
        $headers=[
            'accept: application/json',
            'content-type: application/json',
        ];
        $provider = $this->getGoogleOcrProvider();
        return $provider->checkInGoogle($rq,$headers,$api);
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
