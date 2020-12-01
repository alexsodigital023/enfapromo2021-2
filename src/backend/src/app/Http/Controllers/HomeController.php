<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
    public function index()
    {


        return view('home',[
            "tickets"=>(object)[
                'nuevos'=>Ticket::select()->where('status_id',1)->where('submited',1)->count(),
                'rechazados'=>Ticket::select()->where('status_id',2)->where('submited',1)->count(),
                'aceptados'=>Ticket::select()->where('status_id',3)->where('submited',1)->count(),
                'premiados'=>Ticket::select()->where('status_id',11)->where('submited',1)->count(),
                'pendientes'=>Ticket::select()->whereIn('status_id',[4,5,6,7,8,9,10])->where('submited',1)->count(),
            ],
            "registros"=>(object)User::select([
                    'dia'=>DB::raw('date(users.created_at) as dia'),
                    'total'=>DB::raw('(count(*)) as total')
                ])->groupBy(DB::raw("date(users.created_at)"))
                ->limit(10)
                ->get(),
            "validos"=>(object)User::select([
                    'dia'=>DB::raw('date(users.created_at) as dia'),
                    'total'=>DB::raw('(count(users.id)) as total')
                ])->groupBy(DB::raw("date(users.created_at)"))
                ->leftJoin("ticket","ticket.user_id","=","users.id")
                ->where("ticket.submited",1)
                ->limit(10)
                ->get(),
        ]);
    }
}
