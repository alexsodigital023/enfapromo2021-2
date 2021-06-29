<?php


namespace App\Sodigital\Services\Ocr;

use App\Sodigital\Interfaces\Services\OcrInterface;
use finfo;
use thiagoalessio\TesseractOCR\TesseractOCR;
use App\Sodigital\Services\Error\FileNotFound;

class Ocr implements OcrInterface{
    protected $_db;
    
    public function run(){
        $tickets=$this->_db->getTickets(1);
        foreach($tickets as $t){
            try{
                $this->_db->updateTicket($t->id,["status_id"=>8]);
                $this->processTicket($t);
            }catch(\Exception $e){
                $this->_db->updateTicket($t->id,
                    [
                        "status_id"=>7,
                        "status_desc"=>$e->getMessage()
                    ]);
            }
        }
    }

    public function processTicket($ticket){
        $time=microtime();
        $path=$ticket;
        if(!file_exists($path)){
            throw new FileNotFound($path);
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        switch(finfo_file($finfo,$path)){
            case "application/pdf":
                $path=$this->convertPDF($path);
            break;
        }

        $text= (new TesseractOCR($path))
            ->psm(6)
            ->run();
        $time2=microtime();


        switch(finfo_file($finfo,$path)){
            case "application/pdf":
                unlink($path);
            break;
        }
        return $text;
    }

    protected function convertPDF($path){
        $tmp=tempnam("tmp","tick");
        $pdf = new \Spatie\PdfToImage\Pdf($path);
        $pdf->saveImage($tmp);
        return $tmp;
    }
}