<div class="form-group{{ $errors->has($eName) ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">{{ ucwords(trans('labels.'.$eLabel))}}</label>
    <div class="col-md-6">
        <textarea class="form-control" rows="5" name="{{$eName}}" {{($enable)?'':'disabled'}} {{isset($len)?'maxlength='.$len.'':''}}>{{isset($eVal)?$eVal:old($eName)}}</textarea>
        @if ($errors->has($eName))
            <span class="help-block">
                <strong>{{ $errors->first($eName) }}</strong>
            </span>
        @endif
    </div>
</div>