@extends('layouts.app')
@section('content')
    <h2>{{trans('titles.approbation.detail')}}: {{$details[0]->batch->id}}</h2>
    <ul class="list-group">
        <li class="list-group-item row">
            <div class="panel-group " id="solicitudes">
                <div class="panel panel-default container">
                @foreach($details as $detail)
                <div class="panel-heading panel-heading-custom row" >
                    <a class="col-md-8" data-toggle="collapse" data-parent="#solicitudes" href="#collapse{{$detail->id}}" aria-expanded="true"  >
                        @if($detail->solicitud->observation<>'')
                            <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                        @endif
                        <span >
                        {{$detail->solicitud->display}}
                        </span>
                    </a>
                    <div class="col-md-4">
                        <table class="botonera">
                            <tr>
                                <td>@can('create.approbation')
                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal"
                                            data-target="#modalcambiar"
                                            id="{{$detail->id}}"
                                            name="Accept">{{trans('labels.accept')}}</button>
                                    @endcan</td>
                                <td>@can('delete.approbation')
                                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                            data-target="#modalcambiar"
                                            id="{{$detail->id}}"
                                            name="Reject">{{trans('labels.toReject')}}</button>
                                    @endcan</td>
                                <td>@can('edit.approbation')
                                    <button type="button" class="btn btn-warning btn-xs" data-toggle="modal"
                                            data-target="#modalcambiar"
                                            id="{{$detail->id}}"
                                            name="Object">{{trans('labels.toObject')}}</button>
                                    @endcan</td>
                            </tr>
                        </table>
                    </div>

                </div>
                <div class="panel-collapse collapse" id="collapse{{$detail->id}}" >
                    <div id="detail{{$detail->id}}" class="panel-body">
                        @if($detail->solicitud->observation<>'')
                            <ul class="list-group alert alert-danger text-center">
                                {{$detail->solicitud->observation}}
                            </ul>
                        @endif
                        <ul class="list-group">
                            @foreach($detail->solicitud->fields as $field)
                                <li class="list-group-item">&nbsp;
                                    <span class="label label-info col-md-3 col-md-offset-0">{{trans('labels.fDy.'.$field->format->name_field)}}</span>
                                    <span class="col-md-6">{{$field->valor}}</span>
                                </li>
                            @endforeach
                            <li class="list-group-item">&nbsp;
                                <span class="label label-info col-md-3 col-md-offset-0">{{trans('labels.comments')}}</span>
                                <span class="col-md-6">{{$detail->solicitud->comments}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                @endforeach

                </div>
            </div>
        </li>
    </ul>
    <a href="{{route('approbations')}}" class="btn btn-success btn-xs">{{trans('labels.seeAllApprobation')}}</a>

    @include('layouts.modal.action_approbe')
@endsection

@section('extra_js')
    <script>
        $('#modalcambiar').on('show.bs.modal', function(e) {
            var $modal = $(this),
                    esseyId = e.relatedTarget.id;
            var $documento = $modal.find('#document');
            var $accion = e.relatedTarget.name;
            var $titulo='',$contenido='';
            if($accion=='Accept'){
                //$documento.removeClass('modal-lg');
                $documento.addClass('modal-sm');
                $titulo = 'Está seguro que desea Aceptar la solicitud?';
                $contenido = '<input type="hidden" name="approbation_id" value="'+esseyId+'">';
                $contenido += '<input type="hidden" name="action_id" value="'+$accion+'">';
            }else if($accion=='Reject'){
                $documento.removeClass('modal-sm');
                //$documento.addClass('modal-lg');
                $titulo = 'Está seguro que desea Rechazar la solicitud?';
                $contenido = '<input type="hidden" name="approbation_id" value="'+esseyId+'">';
                $contenido += '<input type="hidden" name="action_id" value="'+$accion+'">';
                $contenido += '<div class="label label-primary" name="lb_observation">Motivo</div>';
                $contenido += '<textarea class="form-control" name="observation" rows="5"></textarea>';
            }
            else{
                $documento.removeClass('modal-sm');
                //$documento.addClass('modal-lg');
                $titulo = 'Está seguro que desea Enviar Reparos a la solicitud?';
                $contenido = '<input type="hidden" name="approbation_id" value="'+esseyId+'">';
                $contenido += '<input type="hidden" name="action_id" value="'+$accion+'">';
                $contenido += '<div class="label label-primary" name="lb_observation">Motivo</div>';
                $contenido += '<div><textarea class="form-control" name="observation" rows="5"></textarea></div>';
            }

            $modal.find('#ModelApplyAction').html($titulo);
            $modal.find('.edit-content').html($contenido);
        })
    </script>
@endsection