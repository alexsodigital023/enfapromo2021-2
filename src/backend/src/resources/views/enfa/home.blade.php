@extends('layouts.administrator')
@section('title', 'Dashboard')
@section('content')

<div class="row row-mobile pb-4">
    <div class="col">
        <div class="card">
            <div class="container">
                <div class="card-header">
                    <h2>Tickets</h2>
                </div>
                <div class="card-body">
                    <totales-chart
                        nuevos="{{$tickets->nuevos}}"
                        rechazados="{{$tickets->rechazados}}"
                        aceptados="{{$tickets->aceptados}}"
                        premiados="{{$tickets->premiados}}"
                        pendientes="{{$tickets->pendientes}}"
                    ></totales-chart>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="container">
                <div class="card-header">
                    <h2>Registro de Participantes</h2>
                </div>
                <div class="card-body">
                    <recepciones-chart
                        registros="{{json_encode($registros)}}"
                        validos="{{json_encode($validos)}}"
                        nuevos="{{$tickets->nuevos}}"
                        rechazados="{{$tickets->rechazados}}"
                        aceptados="{{$tickets->aceptados}}"
                        premiados="{{$tickets->premiados}}"
                        pendientes="{{$tickets->pendientes}}"
                    ></recepciones-chart>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
