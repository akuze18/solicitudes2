@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{trans('labels.newRole')}}</div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{route('roles.store')}}">

            {!! csrf_field() !!}
            @include('layouts.form.select',fData('area_id_rol',null,$areas))
            @include('layouts.form.textbox',fData('slug'))
            @include('layouts.form.textbox',fData('name'))
            @include('layouts.form.textbox',fData('description'))
            @include('layouts.form.submit',fData('toCreate'))
        </form>
    </div>
    <div class="panel-footer"><a href="{{route('roles')}}" class="btn btn-success btn-xs">{{trans('labels.seeAllRol')}}</a> </div>
</div>
@endsection
@section('extra_js')
    <script language="javascript">
        $(document).ready(function() {
            $("#area_id_rol").change(completeSName).trigger('change');
            function completeSName(){
                var $area_id = $(this).val();
                if($area_id!=null){
                    $.post("{{route('getAreaSname')}}",{area_id: $area_id}, function(data){
                        $("#slug").val(data+'.');
                    });
                }
            }
        });
    </script>
@endsection