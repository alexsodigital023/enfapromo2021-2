<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Status;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $profiles=Profile::select()
            ->where([
                "assignable"=>1
            ]);

        $users=User::select("users.*")
            ->leftJoin("profile","profile.id","=","users.profile_id",[])
            ->where([
                "profile.assignable"=>1
            ])
            ->orderBy("users.id")
            ->paginate(10);

        return view('users',[
            "users"=>$users,
            "profiles"=>$profiles
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
            if($request->get("password")!==null){
                $change=[
                    "password"=>Hash::make($request->get("password"))
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
