<?php

namespace App\Sodigital\Services\Ocr;

use App\Mutators\Storage\Spaces;
use App\Sodigital\Interfaces\Providers\GoogleOcrProvider;
use GoogleCloudVision\Request\AnnotateImageRequest;
$api = env('GOOGLE_OCR_API', 'xxxxx');

trait GoogleOcr
{
    use Spaces;

    //Envía una petición a google para reconocimiento de texto
    public function checkInGoogle($url)
    {
        $api = env('GOOGLE_OCR_API', '');
        $features = "TEXT_DETECTION";
        $request = new AnnotateImageRequest();
        $request->setImageUri($url);
        $request->setFeature($features);
        $rq = array(
            "requests" => $request
        );
        $headers=[
            'accept: application/json',
            'content-type: application/json',
        ];
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
    //Devuelve una instancia del manejador de google para OCR
    public function getGoogleOcrProvider($rq,$headers)
    {
        //devolver una instancia del provider para google
        return new GoogleOcrProvider($rq,$headers);

    }
}
