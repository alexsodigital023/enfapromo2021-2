@extends('layouts.administrator')
@section('title')
<i class="fa fa-users"></i>
Participantes
@endsection('title')
@section('content')

<div class="row">
    <div class="card shadow mb-4 w-100 d-block">
        <div class="card-head">
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="">
                        <participantes >
                        @foreach($users as $u)
                            <data
                                id="{{$u->id}}"
                                name="{{$u->nombre}} {{$u->apellido}}"
                                profile="{{$u->profile->name}}"
                                profile_id="{{$u->profile_id}}"
                                email="{{$u->email}}"
                                oauth="{{$u->oauth}}"
                                activo="{{$u->activo}}"
                                backend="{{$u->backend}}",
                                update="{{route('user/update',['id'=>$u->id])}}"
                                tickets="{{$u->ticket->count()}}"
                                aprobados="{{$u->ticket->where('status_id',3)->count()}}"
                                rechazados="{{$u->ticket->where('status_id',2)->count()}}"
                                nuevos="{{$u->ticket->where('status_id',1)->count()}}"
                                premiados="{{$u->ticket->where('status_id',10)->count()}}"
                            ></data>
                        @endforeach
                        </participantes>
                        {{ $users->appends($_GET)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
