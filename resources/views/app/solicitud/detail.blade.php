@extends('layouts.app')
@section('content')
    <h2>{{trans('titles.solicitude.detail')}}: {{$mySolicitud->id}}</h2>
    <ul class="list-group">
        <li class="list-group-item row">
            <span class="label label-primary col-md-2">{{trans('labels.estado')}}</span>
            <span class="col-md-7">{{$estado}}</span>
            @if($estado=='ESPERA')
                <span class="col-md-2">
                    <a href="{{route('solicitude.create',$mySolicitud->id)}}"
                       class="btn btn-success btn-xs">{{trans('labels.add')}}</a>
                </span>
            @endif
        </li>
        <li class="list-group-item row">
            <div class="panel-group" id="solicitudes">
                <div class="panel panel-default container">
                    @foreach($mySolicitud->status($estado) as $detail)
                    <div class="panel-heading panel-heading-custom row">
                        <a data-toggle="collapse" data-parent="#solicitudes" href="#collapse{{$detail->id}}" aria-expanded="true"  >

                            <span class="col-md-8">
                                @if($detail->estado_id==$objetado->id)<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>@endif
                                @if(!is_null($detail->reference))<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>@endif
                            {{$detail->display}}
                            </span>
                        </a>
                        <span class="col-md-3">
                            @if($estado=='ESPERA')
                            <table class="botonera" id="opciones_espera">
                                <tr>
                                    <td>
                                        @can('edit.solicitude')
                                        <a href="{{route('solicitude.edit',[$detail->id])}}" class="btn btn-warning btn-xs">{{trans('labels.edit')}}</a>
                                        @endcan
                                    </td>
                                    <td>
                                        @can('delete.solicitude')
                                        <form action="{{route('solicitude.destroy.detail',[$detail->id])}}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" id="delete-task-{{ $detail->id }}" class="btn btn-danger btn-xs">
                                                <i class="fa fa-btn fa-trash"></i>{{trans('labels.toDelete')}}
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            </table>
                            @endif
                            @if($estado=='ENVIADO')
                            <table class="botonera" id="opciones_enviado">
                                <tr>
                                    <td>
                                        <button class="btn btn-primary btn-xs" data-toggle="modal"
                                           data-target="#modalcambiar"
                                           id="{{$detail->id}}">
                                            {{$detail->actual_approbation}} de {{$detail->max_approbation}} aprobados
                                        </button></td>
                                </tr>
                            </table>
                            @endif
                            @if($estado=='RECHAZADO')
                                <table class="botonera" id="opciones_rechazado">
                                    <tr>
                                        <td>
                                            <button class="btn btn-primary btn-xs" data-toggle="modal"
                                                    data-target="#modalcambiar"
                                                    id="{{$detail->id}}">
                                                {{$detail->actual_approbation}} de {{$detail->max_approbation}} aprobados
                                            </button>
                                        </td>
                                        <td>
                                            <a href="{{route('solicitude.create',['solicitud_id'=>null,'old'=>$detail->id])}}" class="btn btn-success btn-xs">
                                               Reenviar
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            @endif
                        </span>
                    </div>
                    <div class="panel-collapse collapse" id="collapse{{$detail->id}}" >
                        <div id="detail{{$detail->id}}" class="panel-body">
                            @if($detail->estado_id==$objetado->id)
                            <ul class="list-group alert alert-danger text-center">
                                <strong>OBJETADO</strong>
                                {{$detail->observation}}
                            </ul>
                            @endif
                            <ul class="list-group">
                                @foreach($detail->fields as $field)
                                    <li class="list-group-item">&nbsp;
                                        <span class="label label-info col-md-3 col-md-offset-0">{{trans('labels.fDy.'.$field->format->name_field)}}</span>
                                        <span class="col-md-6">{{$field->valor}}</span>
                                    </li>
                                @endforeach
                                <li class="list-group-item">&nbsp;
                                    <span class="label label-info col-md-3 col-md-offset-0">{{trans('labels.comments')}}</span>
                                    <span class="col-md-6">{{$detail->comments}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </li>
    </ul>
    <a href="{{route('solicitudes',$estado)}}" class="btn btn-success btn-xs">{{trans('labels.seeAllSolicitude')}}</a>

    @include('layouts.modal.show_approbation_line')
@endsection

@section('extra_js')
    <script>
        $('#modalcambiar').on('show.bs.modal', function(e) {
            var $modal = $(this),
                    esseyId = e.relatedTarget.id;
            var $titulo='',$contenido='';

            $titulo = 'Estado de las Aprobaciones';
            $modal.find('#ModalShowApprobations').html($titulo);
            $.post("{{route('getApprobationStatus')}}",{detail_id: esseyId}, function(data){
                $modal.find('.edit-content').html(data);
                //$contenido = data;
            });
            //$modal.find('.edit-content').html($contenido);
        })
    </script>
@endsection