@extends('layouts.app')
@section('content')
    <h2>Usuarios</h2>
    @if ($errors->has('mensaje'))
    <div class="alert alert-danger text-center displayIn">
        <strong >{{ $errors->first('mensaje') }}</strong>
    </div>
    @endif
    <table class="table table-condensed">
        <thead class="thead-inverse">
        <tr class="bg-primary">
            <th width="18%">{{trans('model.user.first_name')}}</th>
            <th width="18%">{{trans('model.user.last_name')}}</th>
            <th width="18%">{{trans('model.user.email')}}</th>
            <th width="18%">{{trans('model.user.rol_id')}}</th>
            <th colspan="3" class="text-center">{{trans('labels.actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->first_name}}</td>
                <td>{{$user->last_name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->roles[0]->description}}</td>
                <td>
                    @can('see.user')
                    <a href="{{route('user',$user->username)}}" class="btn btn-info btn-xs">{{trans('labels.seeDetail')}}</a>
                    @endcan
                </td>
                <td>
                    @can('edit.user')
                    <a href="{{route('users.edit',[$user->username])}}" class="btn btn-warning btn-xs">{{trans('labels.edit')}}</a>
                    @endcan
                </td>
                <td>
                    @can('delete.user')
                    @if(!$user->hasRole('admin'))
                    <form action="{{route('users.destroy',[$user->id])}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" id="delete-task-{{ $user->id }}" class="btn btn-danger btn-xs">
                            <i class="fa fa-btn fa-trash"></i>{{trans('labels.toDelete')}}
                        </button>
                    </form>
                    @endif
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7">
                    @can('create.user')
                    <p></p>
                    <a href="{{route('users.create')}}" class="btn btn-success btn-xs">{{trans('labels.add')}}</a>
                    @endcan
                </td>
            </tr>
        </tfoot>
    </table>
    {!! $users->render() !!}
@endsection
@section('extra_js')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(function() {
                $(".displayIn").fadeOut(300);
            },5000);
        });
    </script>
@endsection