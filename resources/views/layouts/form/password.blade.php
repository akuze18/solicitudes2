<div class="form-group{{ $errors->has($eName) ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">{{ ucwords(trans('labels.'.$eLabel))}}</label>
    <div class="col-md-6">
        <input type="password" class="form-control" name="{{$eName}}" value="{{ old($eName) }}">

        @if ($errors->has($eName))
            <span class="help-block">
                <strong>{{ $errors->first($eName) }}</strong>
            </span>
        @endif
    </div>
</div>