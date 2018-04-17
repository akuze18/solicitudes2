<div class="form-group{{ $errors->has($eName) ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">{{ ucwords(trans('labels.'.$eLabel))}}</label>
    <div class="col-md-6">
        <input type="number" class="form-control" name="{{$eName}}" id="{{$eName}}"
                {{($enable)?'':'disabled'}} {{isset($len)?'max='.$len.'':''}}
                min="1" step="1"
               value="{{isset($eVal)?$eVal:old($eName)}}">

        @if ($errors->has($eName))
            <span class="help-block">
                <strong>{{ $errors->first($eName) }}</strong>
            </span>
        @endif
    </div>
</div>