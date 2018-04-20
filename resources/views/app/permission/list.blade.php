@extends('layouts.app')
@section('content')
<table class="table table-hover">
    <thead>
        <th width="80%"><h2>{{trans('labels.permissions')}}</h2></th>
        <th colspan="2">&nbsp;</th>
    </thead>
    @if ($errors->has('mensaje'))
        <tbody><tr><td colspan="3" class="label-danger text-center">
                <strong >{{ $errors->first('mensaje') }}</strong>
            </td></tr></tbody>
    @endif
    <tbody style="background-color: white">
        @foreach ($permissions as $permission)
            <tr class="">
                <td>{{ $permission->name }} <span class="badge">{{$permission->roles->count()}} Roles</span></td>
                <td>
                    @can('see.permission')
                    <a href="{{route('permission',[$permission->slug])}}" class="btn btn-info btn-xs">{{trans('labels.seeDetail')}}</a>
                    @endcan
                </td>
                <td>
                    @can('edit.permission')
                    <a href="{{route('permissions.edit',[$permission->slug])}}" class="btn btn-warning btn-xs">{{trans('labels.edit')}}</a>
                    @endcan
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{!! $permissions->render() !!}
@endsection