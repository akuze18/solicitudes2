@extends('layouts.app')
@section('content')
<table class="table table-hover">
    <thead>
        <tr>
            <th>
                <h2>{{trans('titles.solicitudeType.list')}}</h2>
            </th>
        </tr>
    </thead>
    @if ($errors->has('mensaje'))
    <tbody>
        <tr>
            <td class="label-danger text-center">
                <strong >{{ $errors->first('mensaje') }}</strong>
            </td>
        </tr>
    </tbody>
    @endif
    <tbody style="background-color: white">
        @foreach ($types as $type)
            <tr class="">
                <td>
                    <div class="col-lg-8">{{ $type->name }}</div>
                    <div class="col-lg-4 botonera">
                    @permission('see.menu')
                        <a href="{{route('solicitudeType',[$type->id])}}" class="btn btn-info btn-xs">{{trans('labels.seeDetail')}}</a>
                    @endpermission
                    @permission('edit.menu')
                        <a href="{{route('solicitudeType.edit',[$type->id])}}" class="btn btn-warning btn-xs">{{trans('labels.edit')}}</a>
                    @endpermission

                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{!! $types->render() !!}
@endsection