<?php

namespace App\Http\Controllers;


use App\Profile;
use App\Status;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use App\Mutators\Storage\Spaces;
use App\Sodigital\Services\Ocr\Ocr;
use App\Sodigital\Services\Regex\Regex;

class ServiceController extends Controller
{
    use Spaces;
    public function run(Request $request){
        $ticket=Ticket::find($request->get("id"));
        if(!$ticket){
            throw new \Exception("ticket inexistente");
        }
        $tmpFile=tempnam(sys_get_temp_dir(),'ticket_');
        file_put_contents($tmpFile,$this->getFile($ticket->path));
        $ocr=new Ocr();
        $ticket->status_id=4;
        $ticket->save();
        $time=time();
        $text=$ocr->processTicket($tmpFile);
        $time2=time();
        $ticket->status_id=4;
        $ticket->data=$text;
        $ticket->process_time=$time2-$time;
        $ticket->save();
        $regex=new Regex();
        $status=$regex->processTicket($ticket);
        unlink($tmpFile);
        return json_encode($ticket);
    }
}