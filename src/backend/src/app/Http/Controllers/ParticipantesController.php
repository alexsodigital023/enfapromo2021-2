<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Status;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;

class ParticipantesController extends Controller
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
        $users=User::select([
                "users.*",
                "ticket.nombre",
                "ticket.apellido"
                ])
            ->distinct()
            ->leftJoin("profile","profile.id","=","users.profile_id")
            ->leftJoin("ticket","ticket.user_id","=","users.id")
            ->where([
                "profile.assignable"=>0,
                "ticket.submited"=>1
            ])
            ->orderBy("users.id")
            ->paginate(10);

        return view('participantes',[
            "users"=>$users
        ]);
    }

    public function update($id,Request $request)
    {
        try{
            $change=[];
            if($request->get("profile_id")){
                $change=[
                    "profile_id"=>$request->get("profile_id")
                ];
            }
            if($request->get("name")){
                $change=[
                    "name"=>$request->get("name")
                ];
            }
            if($request->get("email")){
                $change=[
                    "email"=>$request->get("email")
                ];
            }
            if($request->get("oauth")!==null){
                $change=[
                    "oauth"=>$request->get("oauth")?1:0
                ];
            }
            if($request->get("activo")!==null){
                $change=[
                    "activo"=>$request->get("activo")?1:0
                ];
            }
            if($request->get("backend")!==null){
                $change=[
                    "backend"=>$request->get("backend")?1:0
                ];
            }
            if(count($change)){
                User::where([
                    "id"=>$id
                ])->update($change);
            }
            return response()->json([
                "error"=>0,
                "message"=>"",
            ]);
        }catch(\Exception $e){
            return response()->json([
                "error"=>$e->getCode(),
                "message"=>$e->getMessage(),
            ]);
        }
    }
}
