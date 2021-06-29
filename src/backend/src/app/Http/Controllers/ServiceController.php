<?php

namespace App\Http\Controllers;


use App\Profile;
use App\Status;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use App\Mutators\Storage\Spaces;
use App\Sodigital\Interfaces\Controllers\ServiceControllerInterface;
use App\Sodigital\Services\Ocr\Ocr;
use App\Sodigital\Services\Regex\Regex;

class ServiceController extends Controller implements ServiceControllerInterface
{
    use Spaces;
    public function run(Request $request){
        set_time_limit(60);
        $ticket=Ticket::find($request->get("id"));
        if(!$ticket){
            throw new \Exception("ticket inexistente");
        }
        if($ticket->status_id==1
            ||$ticket->status_id==7
            ||$ticket->status_id==8
            ){
            $ticket->status_id=8;
            $ticket->save();
            $tmpFile=tempnam(sys_get_temp_dir(),'ticket_');
            file_put_contents($tmpFile,$this->getFile($ticket->path));
            
            $ocr=new Ocr();
            $time=time();
            $text=$ocr->processTicket($tmpFile);
            $time2=time();
            $ticket->status_id=strlen($ticket->data)>5?4:7;
            $ticket->submited=1;
            $ticket->data=$text;
            $ticket->process_time=$time2-$time;
            $ticket->save();
            unlink($tmpFile);
        }
        if(strlen($ticket->data)>5){
            $regex=new Regex();

            $ticket->status_id=9;
            $ticket->save();
            $status=$regex->processTicket($ticket);
        }
        return json_encode([
            "id"=>$ticket->id,
            "status_id"=>$ticket->status_id,
            "importe"=>$ticket->import
        ]);
    }
}