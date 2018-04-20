@extends('layouts.app')
@section('content')
<table class="table table-hover">
    <thead>
        <tr>
            <th><h2 class="col-md-12">{{trans('titles.area.list')}}</h2></th>
        </tr>
    </thead>
    @if ($errors->has('mensaje'))
        <tbody>
            <tr>
                <td class="alert alert-danger alert-min">
                    <span class="col-md-12">{{ $errors->first('mensaje') }}</span>
                </td>
            </tr>
        </tbody>
    @endif
    <tbody style="background-color: white">
    @foreach ($areas as $area)
        <tr>
            <td>
                <span class="col-md-8">
                    {{ $area->name }} <span class="badge">{{trans('titles.role.list').' '.$area->roles->count()}}</span>
                </span>
                <span class="col-md-4 botonera">
                @can('see.area')
                    <a href="{{route('area',[$area->name])}}" class="btn btn-info btn-xs">{{trans('labels.seeDetail')}}</a>
                @endcan
                    @can('edit.area')
                    <a href="{{route('areas.edit',[$area->name])}}" class="btn btn-warning btn-xs">{{trans('labels.edit')}}</a>
                @endcan
                    @can('delete.area')
                        <button type="button" data-toggle="modal" data-target="#modalconfirmar"
                                data-id="{{ $area->id }}" data-name="{{ $area->name }}" class="btn btn-danger btn-xs">{{trans('labels.toDelete')}}
                        </button>
                    @endcan
                </span>
            </td>
        </tr>
    @endforeach
    </tbody>
    @can('create.area')
    <tfoot>
        <tr>
            <td>
                <p></p>
                <a href="{{route('areas.create')}}" class="btn btn-success btn-xs">{{trans('labels.add')}}</a>
            </td>
        </tr>
    </tfoot>
    @endcan
</table>
{!! $areas->render() !!}
    @include('layouts.modal.confirm_delete_area')
@endsection
@section('extra_js')
    <script language="javascript">
        $('#modalconfirmar').on('show.bs.modal', function(e) {
            var $modal = $(this);
            var $val = e.relatedTarget.getAttribute('data-id');
            var $name = e.relatedTarget.getAttribute('data-name');
            var $titulo = 'Confirma Eliminar Area';
            var $contenido = '<input type="hidden" name="area_id" value="'+$val+'">';
            $contenido += ' <p class="text-center">'+$name+'</p>';
            $modal.find('#ModalTitle').html($titulo);
            $modal.find('.edit-content').html($contenido);

        })
    </script>
@endsection