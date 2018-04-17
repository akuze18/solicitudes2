@extends('layouts.app')
@section('content')
<table class="table table-hover">
    <thead>
        <th width="80%"><h2>{{trans('titles.role.list')}}</h2></th>
        <th colspan="3">&nbsp;</th>
    </thead>
    @if ($errors->has('mensaje'))
        <tbody><tr><td colspan="4" class="label-danger text-center">
                <strong >{{ $errors->first('mensaje') }}</strong>
            </td></tr></tbody>
    @endif
    <tbody style="background-color: white">
        @foreach ($roles as $role)
            <tr>
                <td>{{ $role->namefull }} <span class="badge">Usuarios {{$role->users->count()}}</span></td>
                <td>
                    @permission('see.role')
                    <a href="{{route('role',[$role->slug])}}" class="btn btn-info btn-xs">{{trans('labels.seeDetail')}}</a>
                    @endpermission
                </td>
                <td>
                    @permission('edit.role')
                    <a href="{{route('roles.edit',[$role->slug])}}" class="btn btn-warning btn-xs">{{trans('labels.edit')}}</a>
                    @endpermission
                </td>
                <td>
                    @permission('delete.role')
                    <form action="{{route('roles.destroy',[$role->id])}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" id="delete-task-{{ $role->id }}" class="btn btn-danger btn-xs">
                            <i class="fa fa-btn fa-trash"></i>{{trans('labels.toDelete')}}
                        </button>
                    </form>
                    @endpermission
                </td>
            </tr>
        @endforeach
    </tbody>
    @permission('create.role')
    <tbody>
        <tr><td><p></p><a href="{{route('roles.create')}}" class="btn btn-success btn-xs">{{trans('labels.add')}}</a></td></tr>
    </tbody>
    @endpermission
</table>
{!! $roles->render() !!}
@endsection