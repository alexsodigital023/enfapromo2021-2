<?php


namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model{
    protected $table="ticket";

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function estado(){
        return $this->belongsTo(Estado::class);
    }
    public function tienda(){
        return $this->belongsTo(Tienda::class);
    }
    public function status(){
        return $this->belongsTo(Status::class);
    }
    public function getImageData(){
        $path=$this->path;
        if(!$path||!file_exists($path)){
            throw new \Exception("El archivo no $path existe ",404);
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        $img=null;

        switch(finfo_file($finfo,$path)){
            case "application/pdf":
                $path=$this->convertPDF($path);
            break;
        }

        switch(finfo_file($finfo,$path)){
            case "image/jpeg":
            case "image/jpg":
                $img='data:image/jpg;base64,'.base64_encode(file_get_contents($path));
            break;
            case "image/png":
                $img='data:image/png;base64,'.base64_encode(file_get_contents($path));
            break;
            case "image/gif":
                $img='data:image/gif;base64,'.base64_encode(file_get_contents($path));
            break;
            case "image/webp":
                $img='data:image/webp;base64,'.base64_encode(file_get_contents($path));
            break;
            default:
                throw new \Exception("Formato de imagen no soportado",400);
            break;
        }
        return $img;
    }

    protected function convertPDF($path){
        $tmp=tempnam("tmp","tick");
        $pdf = new \Spatie\PdfToImage\Pdf($path);
        $pdf->saveImage($tmp);
        return $tmp;
    }
}