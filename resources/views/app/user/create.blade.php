@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{trans('labels.userRegister')}}</div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('users.store') }}">
            {!! csrf_field() !!}
            @include('layouts.form.textbox',fData('first_name'))
            @include('layouts.form.textbox',fData('last_name'))
            @include('layouts.form.textbox',fData('username'))
            @include('layouts.form.textbox',fData('rut'))
            @include('layouts.form.textbox',fData('email'))
            @include('layouts.form.password',fData('password'))
            @include('layouts.form.password',fData('password_confirmation'))
            @include('layouts.form.select',fData('rol_id_user',null,$roles))
            @include('layouts.form.submit',fData('toRegister'))
        </form>
    </div>
</div>
@endsection
@section('extra_js')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#first_name").change(checkNames).trigger('change');
            $("#last_name").change(checkNames).trigger('change');

            function checkNames(){
                var $last_name = $("#last_name").val();
                var $first_name = $("#first_name").val();
                if($last_name!='' && $first_name!=''){
                    var $value = $first_name.substring(0,1)+$last_name;
                    $("#username").val($value.toLowerCase());
                    $("#email").val($value.toLowerCase()+'@'+'{{env('COMP_MAIL_DOMAIN')}}');
                }
            }
        });
    </script>
@endsection