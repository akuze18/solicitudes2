@extends('layouts.app')
@section('content')
<table class="table table-hover">
    <thead>
    <tr>
        <th width="80%"><h2>{{trans('titles.solicitude.list').' '.$OEstado->name}}</h2></th>
        <th colspan="2">&nbsp;</th>
    </tr>
    </thead>
    @if ($errors->has('mensaje'))
        <tbody><tr><td colspan="3" class="label-danger text-center">
        <strong >{{ $errors->first('mensaje') }}</strong>
            </td></tr></tbody>
    @endif
    <tbody style="background-color: white">
    @foreach ($mySolicitudes as $solicitude)
        <tr>
            <td>
                Solicitud Nº:{{ $solicitude->id }} <span class="badge">{{ $solicitude->status($estado)->count().' de '.$solicitude->details()->count() }}</span>
                @if($solicitude->status($estado)->where('estado_id',$objetado->id)->count()==1)<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> @endif
                @if($solicitude->status($estado,true)->count()>0)<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> @endif
                @if($nuevo==$solicitude->id) <span class="newIn">NUEVO</span> @endif
            </td>
            <td>
                @if($OEstado->slug=='T')
                    <table class="botonera" id="opciones_espera">
                        <tr>
                            <td>
                                @permission('see.solicitude')
                                <a href="{{route('solicitude',[$estado,$solicitude->id])}}" class="btn btn-info btn-xs">{{trans('labels.seeDetail')}}</a>
                                @endpermission
                            </td>
                            <td>
                                @permission('create.solicitude')
                                <a href="{{route('solicitude.create',[$solicitude->id])}}" class="btn btn-success btn-xs">{{trans('labels.addNew')}}</a>
                                @endpermission
                            </td>
                            <td>
                                @permission('delete.solicitude')
                                <form action="{{route('solicitude.destroy.batch',[$solicitude->id])}}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" id="delete-task-{{ $solicitude->id }}" class="btn btn-danger btn-xs">
                                        <i class="fa fa-btn fa-trash"></i>{{trans('labels.toDelete')}}
                                    </button>
                                </form>
                                @endpermission
                            </td>
                            <td>
                                @permission('edit.solicitude')
                                <form action="{{route('solicitude.generate',[$solicitude->id])}}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <button type="submit" id="delete-task-{{ $solicitude->id }}" class="btn btn-warning btn-xs">
                                        <i class="fa fa-btn fa-trash"></i>{{trans('labels.toSend')}}
                                    </button>
                                </form>
                                @endpermission
                            </td>
                        </tr>
                    </table>
                @endif
                @if($OEstado->slug=='E')
                    <table class="botonera" id="opciones_enviado">
                        <tr>
                            <td>
                                @permission('see.solicitude')
                                <a href="{{route('solicitude',[$estado,$solicitude->id])}}" class="btn btn-info btn-xs">{{trans('labels.seeDetail')}}</a>
                                @endpermission
                            </td>
                        </tr>
                    </table>
                @endif
                @if($OEstado->slug=='A')
                    <table class="botonera" id="opciones_aprobado">
                        <tr>
                            <td>
                                @permission('see.solicitude')
                                <a href="{{route('solicitude',[$estado,$solicitude->id])}}" class="btn btn-info btn-xs">{{trans('labels.seeDetail')}}</a>
                                @endpermission
                            </td>
                        </tr>
                    </table>
                @endif
                @if($OEstado->slug=='R')
                    <table class="botonera" id="opciones_rechazado">
                        <tr>
                            <td>
                                @permission('see.solicitude')
                                <a href="{{route('solicitude',[$estado,$solicitude->id])}}" class="btn btn-info btn-xs">{{trans('labels.seeDetail')}}</a>
                                @endpermission
                            </td>
                        </tr>
                    </table>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
    @if($OEstado->slug=='T')
        @permission('create.solicitude')
        <tfoot>
        <tr><td colspan="3"><p></p><a href="{{route('solicitude.create')}}" class="btn btn-success btn-xs">{{trans('labels.add')}}</a></td></tr>
        </tfoot>
        @endpermission
    @endif
</table>
{!! $mySolicitudes->render() !!}
@endsection
@section('extra_js')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(function() {
            $(".newIn").fadeOut(1500);
            },5000);
        });
    </script>
@endsection