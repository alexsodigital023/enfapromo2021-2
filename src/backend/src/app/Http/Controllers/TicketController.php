<?php

namespace App\Http\Controllers;

use App\Exports\TicketExport;
use App\Status;
use App\Ticket;
use App\Log;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $status_id = $request->get("status",3);
        $week = $request->get("week",date("W"));
        $search=$request->get("search");
        $page=$request->get("page",1);

        $status=Status::find($status_id);

        $catStatus=Status::select();

        $tickets=Ticket::select('ticket.*')
            ->where([
                "status_id"=>$status_id,
                "week"=>$week
            ])
            ->orderBy("ticket.id")
            ;
        if($request->get("invalidos",0)!=1){
            //$tickets->where('submited',1);
        }
        if($search){
            $tickets
                ->leftJoin('users','users.id','=','ticket.user_id')
                ->where('users.email','like','%'.trim($search).'%');
        }
        return view('tickets',[
            'tickets'=>$tickets->paginate(10),
            'status'=>$status,
            'catStatus'=>$catStatus,
            'week'=>$week,
            'search'=>$search,
            'page'=>$page,
            "invalidos"=>$request->get("invalidos",0)
        ]);
    }
    public function getImage($id){
        try{
            $ticket = Ticket::find($id);
            $image=$ticket->getImageData();
            return response()->json([
                "error"=>0,
                "message"=>"",
                "data"=>$image
            ]);
        }catch(\Exception $e){
            return response()->json([
                "error"=>$e->getCode(),
                "message"=>$e->getMessage(),
            ]);
        }
    }
    protected function log($data){

        $log=new Log();
        $log->user_id= Auth::id();
        $log->data=json_encode($data);
        $log->save();
    }
    public function aprobar($id){
        try{
            Ticket::where(["id"=>$id])
                ->update([
                    "status_id"=>3
                ]);
            $this->log([
                "ticket_id"=>$id,
                "status_id"=>3
            ]);
            return response()->json([
                "error"=>0,
                "message"=>""
            ]);
        }catch(\Exception $e){
            return response()->json([
                "error"=>$e->getCode(),
                "message"=>$e->getMessage(),
            ]);
        }
    }
    public function rechazar($id){
        try{
            Ticket::where(["id"=>$id])
                ->update([
                    "status_id"=>2
                ]);
            $this->log([
                "ticket_id"=>$id,
                "status_id"=>2
            ]);
            return response()->json([
                "error"=>0,
                "message"=>""
            ]);
        }catch(\Exception $e){
            return response()->json([
                "error"=>$e->getCode(),
                "message"=>$e->getMessage(),
            ]);
        }
    }
    public function premiar($id,Request $request){
        try{
            $ticket=Ticket::find($id);
            if(!$ticket){
                throw new \Exception("Ticket no encontrado",404);
            }
            $prioridad=$request->prioridad?$request->prioridad:99;
            $premiados=Ticket::where([
                "status_id"=>11,
                "week"=>$ticket->week
            ])->count();
            if($premiados > 100){
                throw new \Exception("Ya todos fueron premiados",400);
            }
            if($prioridad<>99){
                Ticket::where(["prioridad"=>$prioridad,"week"=>$ticket->week])
                    ->update([
                        "prioridad"=>99,
                    ]);
            }
            Ticket::where(["id"=>$id])
                ->update([
                    "status_id"=>11,
                    "prioridad"=>$prioridad,
                ]);
            $this->log([
                "ticket_id"=>$id,
                "status_id"=>11,
                "prioridad"=>$prioridad,
            ]);
            return response()->json([
                "error"=>0,
                "message"=>"",
                "premiados"=>$premiados,
                "ticket"=>$ticket
            ]);
        }catch(\Exception $e){
            return response()->json([
                "error"=>$e->getCode(),
                "message"=>$e->getMessage(),
            ]);
        }
    }
    public function despremiar($id){
        try{
            $ticket=Ticket::find($id);
            if(!$ticket){
                throw new \Exception("Ticket no encontrado",404);
            }
            Ticket::where(["id"=>$id])
                ->update([
                    "status_id"=>3,
                    "prioridad"=>99
                ]);
            
            $this->log([
                "ticket_id"=>$id,
                "status_id"=>3,
                "prioridad"=>99
            ]);
            return response()->json([
                "error"=>0,
                "message"=>"",
                "ticket"=>$ticket
            ]);
        }catch(\Exception $e){
            return response()->json([
                "error"=>$e->getCode(),
                "message"=>$e->getMessage(),
            ]);
        }
    }
    public function download($week,Request $request){
        return Excel::download((new TicketExport($week,intval($request->invalidos))), 'tickets.xlsx');
    }
}
