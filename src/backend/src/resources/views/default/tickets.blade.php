@extends('layouts.administrator')
@section('title')
<div class="row">
    <div class="col">
        <i class="fa fa-ticket-alt"></i>
        Tickets
    </div>
    <div class="col">
        <status-selector value="{{$status->id}}">
            @foreach($catStatus->get() as $s)
            <data
                id="{{$s->id}}"
                name="{{$s->name}}"
            ></data>
            @endforeach
        </status-selector>
    </div>
    <div class="col col-4">
        <semana-selector value="{{$week}}"></semana-selector>
    </div>
    <div class="col">
        <a :href="`{{route('ticket/download',['week'=>$week])}}${invalidos?'?invalidos=1':''}`" class="btn btn-primary">
            <i class="fa fa-file"></i>
            Descargar
        </a>
        <label style="font-size:14px;">
            <input type="checkbox" @click="invalidos=!invalidos">
            Incluir inválidos
        </label>
    </div>
</div>
@endsection('title')
@section('content')

<div class="row">
    <div class="card shadow mb-4">
        <div class="card-head">
            <div class="row">
                <div class="col">
                    <search-box value="{{$search}}"></search-box>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="">
                        @if($invalidos==1)
                        <div class="bg-warning">
                            <h2>Mostrando tickets invalidados</h2>
                        </div>
                        @endif
                            <tickets status-id="{{$status->id}}">
                            @foreach($tickets as $t)
                                <data
                                    id="{{$t->id}}"
                                    email="{{$t->user->email}}"
                                    telefono="{{$t->user->telefono}}"
                                    tiempo="{{$t->user->game_t}}"
                                    movimientos="{{$t->user->game_m}}"
                                    estado="{{$t->estado->name}}"
                                    tienda="{{$t->tienda->name}}"
                                    status_id="{{$t->status_id}}"
                                    status="{{$t->status->name}}"
                                    submited="{{$t->submited}}"
                                    product="{{number_format($t->product)}}"
                                    import="{{number_format($t->import,2)}}"
                                    semana="{{date('Y::W',strtotime($t->created_at))}}"
                                    image="{{$t->publicImage()}}"
                                    foto="{{$t->foto}}"
                                    prioridad="{{$t->prioridad}}"
                                    aprobar="{{route('ticket/aprobar',['id'=>$t->id])}}"
                                    rechazar="{{route('ticket/rechazar',['id'=>$t->id])}}"
                                    premiar="{{route('ticket/premiar',['id'=>$t->id])}}"
                                    despremiar="{{route('ticket/despremiar',['id'=>$t->id])}}"
                                ></data>
                            @endforeach
                            </tickets>
                            {{ $tickets->appends($_GET)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
