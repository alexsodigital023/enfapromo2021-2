@extends('layouts.administrator')
@section('title')
<i class="fa fa-user-alt rounded-circle"></i>
Usuarios
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
                        <users profiles-raw="{{json_encode($profiles->get())}}">
                        @foreach($users as $u)
                            <data
                                id="{{$u->id}}"
                                name="{{$u->name}}"
                                profile="{{$u->profile->name}}"
                                profile_id="{{$u->profile_id}}"
                                email="{{$u->email}}"
                                oauth="{{$u->oauth}}"
                                activo="{{$u->activo}}"
                                backend="{{$u->backend}}",
                                update="{{route('user/update',['id'=>$u->id])}}"
                            ></data>
                        @endforeach
                        </users>
                        {{ $users->appends($_GET)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
