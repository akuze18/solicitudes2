@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="jumbotron">
            <h2>Rol: {{$rol->name}}</h2>
            <ul class="list-group">
                @foreach(Schema::getColumnListing('roles')   as $atributo)
                <li class="list-group-item row">
                    <span class="col-md-2"></span>
                    <span class="label label-info col-md-2">{{$atributo}}</span>
                    <span class="col-md-6">{{$rol[$atributo]}}</span>
                    <span class="col-md-2"></span>
                </li>
                @endforeach
            </ul>
            <a href="{{url('/roles')}}"><span class="label label-success">Volver a todos los roles</span></a>
        </div>
    </div> <!-- /container -->
@endsection