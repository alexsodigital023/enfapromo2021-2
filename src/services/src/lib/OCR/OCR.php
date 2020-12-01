<?php


namespace Sodigital\Services\OCR;

use finfo;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Sodigital\Services\Database\Adapter;
use Sodigital\Services\Error\FileNotFound;

class OCR{
    protected $_db;

    function __construct(Adapter $db)
    {
        $this->_db=$db;
    }
    
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

    protected function processTicket($ticket){
        $time=microtime();
        $path=$ticket->path;
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

        $this->_db->updateTicket($ticket->id,["data"=>$text,"status_id"=>4,"process_time"=>$time2-$time]);

        switch(finfo_file($finfo,$path)){
            case "application/pdf":
                unlink($path);
            break;
        }
    }

    protected function convertPDF($path){
        $tmp=tempnam("tmp","tick");
        $pdf = new \Spatie\PdfToImage\Pdf($path);
        $pdf->saveImage($tmp);
        return $tmp;
    }
}