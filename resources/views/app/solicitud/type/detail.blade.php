@extends('layouts.app')
@section('content')
    <h2>{{trans('titles.solicitudeType.detail')}}</h2>
    <ul class="list-group">
        <li class="list-group-item row">
            <span class="label label-primary col-md-2">{{trans('labels.name')}}</span>
            <span class="col-md-6">{{$type->name}}</span>
        </li>
        <li class="list-group-item row">
            <span class="label label-primary col-md-2">{{trans('labels.orderBy')}}</span>
            <span class="col-md-6">{{$type->orderBy}}</span>
        </li>
        <li class="list-group-item row">
            <span class="label label-primary col-md-2">{{trans('labels.actions')}}</span>
        </li>
        @foreach($type->actions as $action)
            <li class="list-group-item row">
                <span class="label label-warning col-md-2 col-lg-offset-1">{{trans('labels.action')}}</span>
                <span class="col-md-6">{{$action->name}}</span>
            </li>
        @endforeach
        <li class="list-group-item row">
            <span class="label label-primary col-md-2">{{trans('labels.fields')}}</span>
        </li>
        <li class="list-group-item row">
            <table class="table table-responsive table-condensed">
                <thead class="title-table">
                    <tr class="info">
                        <th class="col-md-3">{{trans('labels.name')}}</th>
                        <th class="col-md-2">{{trans('labels.type')}}</th>
                        <th class="col-md-2">{{trans('labels.maxLen')}}</th>
                        <th class="col-md-1">{{trans('labels.required')}}</th>
                        <th class="col-md-1">{{trans('labels.title')}}</th>
                        <th class="col-md-3">{{trans('labels.detail')}}</th>
                    </tr>
                </thead>
                <thead>
                @foreach($type->campos as $campo)
                    <tr class="active text-center">
                        <td class="col-md-3">{{$campo->name_display}}</td>
                        <td class="col-md-2">{{$campo->type_field}}</td>
                        <td class="col-md-2">{{$campo->long_field}}</td>
                        <td class="col-md-1">{{$campo->required?'X':''}}</td>
                        <td class="col-md-1">{{$campo->title?'X':''}}</td>
                        <td class="col-md-3">@if($campo->formatLists()->count()>0)
                            <button class="btn btn-xs btn-info" data-toggle="modal"
                                data-target="#modalmostrar" datasrc="{{$campo->id}}">Lista</button>
                        @endif</td>
                    </tr>
                @endforeach
                </thead>
            </table>
        </li>
    </ul>
    <a href="{{route('solicitudeTypes')}}" class="btn btn-success btn-xs">{{trans('labels.seeAllSolicitudeType')}}</a>

    @include('layouts.modal.show_listFormat')
@endsection

@section('extra_js')
    <script>
        $('#modalmostrar').on('show.bs.modal', function(e) {
            var $modal = $(this);
            var $val = e.relatedTarget.getAttribute('datasrc');
            var $titulo = 'Valores Permitidos';
            $modal.find('#ModalShowFormatList').html($titulo);
            $.post("{{route('getFormatList')}}",{field_id: $val}, function(data){
                $modal.find('.edit-content').html(data);
            });
        })
    </script>
@endsection