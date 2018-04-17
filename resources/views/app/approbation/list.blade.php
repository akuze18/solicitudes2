@extends('layouts.app')
@section('content')
<table class="table table-hover">
    <thead>
        <tr>
            <th width="80%"><h2>{{trans('titles.approbation.list')}}</h2></th>
            <th colspan="3">&nbsp;</th>
        </tr>
    </thead>
    @if ($errors->has('mensaje'))
        <tbody><tr><td colspan="4" class="label-danger text-center">
        <strong >{{ $errors->first('mensaje') }}</strong>
            </td></tr></tbody>
    @endif
    <tbody style="background-color: white">
    @foreach ($myApprobations as $approbation)
        <tr class="">
            <td>
                Solicitud Nº:{{ $approbation->batch }}
                <span class="badge">Pendientes {{ $approbation->countBatch }}</span>

                @if($approbation->Objetado>0)<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>@endif
            </td>
            <td>
                @permission('see.approbation')
                <a href="{{route('approbation',[$approbation->batch])}}" class="btn btn-info btn-xs">{{trans('labels.seeDetail')}}</a>
                @endpermission
            </td>
            <td>
                @permission('edit.approbation')
                <a href="{{route('approbation',[$approbation->batch])}}" class="btn btn-warning btn-xs">{{trans('labels.addNew')}}</a>
                @endpermission
            </td>
            <td>
                @permission('delete.approbation')
                <form action="{{route('approbation',[$approbation->batch])}}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" id="delete-task-{{ $approbation->batch }}" class="btn btn-danger btn-xs">
                        <i class="fa fa-btn fa-trash"></i>{{trans('labels.toDelete')}}
                    </button>
                </form>
                @endpermission
            </td>
        </tr>
    @endforeach
    </tbody>

</table>
{!! $myApprobations->render() !!}
@endsection