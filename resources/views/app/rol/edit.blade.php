@extends('layouts.app')
@section('content')
<div class="panel panel-info">
    <div class="panel-heading">{{trans('labels.editRole')}}</div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{route('roles.update',[$rol->id]) }}">
            {{ method_field('PUT') }}
            {!! csrf_field() !!}
            @include('layouts.form.textbox',fData('slug',$rol->slug,[],false))
            @include('layouts.form.textbox',fData('name',$rol->name))
            @include('layouts.form.textbox',fData('description',$rol->description))
            @include('layouts.form.select',fData('area_id_rol',$rol->area->id,$areas))
            @include('layouts.form.submit',fData('edit'))
        </form>
    </div>
    <div class="panel-heading panel-footer">{{trans('labels.editPermissions')}}</div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{route('roles.update.permission',[$rol->id]) }}">
            {{ method_field('PUT') }}
            {!! csrf_field() !!}
            @include('layouts.form.checklist',fData('permission_id_rol',$rol->permissions,$permissions))
            @include('layouts.form.submit',fData('edit'))
        </form>
    </div>
    <div class="panel-footer"><a href="{{route('roles')}}" class="btn btn-success btn-xs">{{trans('labels.seeAllRol')}}</a> </div>
</div>
@endsection

@section('extra_js')
    <script language="javascript">
        $(document).ready(function() {
            $(".panel-heading").click(clickAllGroup);

            function clickAllGroup(){
                var $group = $(this).attr('id');
                var $elements = $(document).find('.select-'+$group);
                $elements.each(function($index){
                    $element = $elements[$index];
                    $element.checked =!($element.checked);
                });
            }
        });
    </script>
@endsection