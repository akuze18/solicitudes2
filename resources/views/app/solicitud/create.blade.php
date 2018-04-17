@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{trans('labels.newSolicitude')}}</div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{route('solicitude.store')}}">
            {!! csrf_field() !!}
            @include('layouts.form.hidden',fData('old',$old))
            @include('layouts.form.hidden',fData('solicitude_id',$bId))
            @include('layouts.form.textbox',fData('user',actualUser()->name,[],false))
            @include('layouts.form.select',fData('solType_id',null,$solType))
            @include('layouts.form.select',fData('action',null,[]))
            @include('layouts.form.submit',fData('next'))
        </form>
    </div>
    <div class="panel-footer"><a href="{{route('solicitudes','ESPERA')}}" class="btn btn-success btn-xs">{{trans('labels.seeAllSolicitude')}}</a> </div>
</div>
@endsection

@section('extra_js')
    <script language="javascript">
        $(document).ready(function(){
            $("#solType_id").change(function () {
                $("#solType_id option:selected").each(function () {
                    var id_category = $(this).val();
                    $.post("{{route('getAction')}}",{typeSol: id_category}, function(data){
                        $("#action").html(data);
                        $(".dynamic_field").html('');
                    });
                });
            }).trigger('change');
        });
    </script>
@endsection