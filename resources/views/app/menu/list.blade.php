@extends('layouts.app')
@section('content')
<table class="table table-hover">
    <thead>
        <tr>
            <th>
                <h2>{{trans('titles.menu.list')}}</h2>
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
        @foreach ($menus as $menu)
            <tr class="">
                <td>
                    <div class="col-lg-3"><span class="badge badge-inverse">{{$menu->header}}</span></div>
                    <div class="col-lg-5">{{ $menu->contain }}</div>
                    <div class="col-lg-4 botonera">
                    @can('see.menu')
                        <a href="{{route('menu',[$menu->id])}}" class="btn btn-info btn-xs">{{trans('labels.seeDetail')}}</a>
                    @endcan
                    @can('edit.menus')
                        <a href="{{route('menu.edit',[$menu->id])}}" class="btn btn-warning btn-xs">{{trans('labels.edit')}}</a>
                    @endcan
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{!! $menus->render() !!}
@endsection