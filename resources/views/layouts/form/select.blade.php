<div class="form-group{{ $errors->has($eName) ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">{{trans('labels.'.$eLabel)}}</label>
    <div class="col-md-6">
        <select class="form-control" name="{{$eName}}" id="{{$eName}}" {{$enable?'':'disabled'}}>
            @if(is_null($eVal))<option selected disabled></option>@endif
            @foreach($elements as $element)
                <option value="{{$element->id}}" @if($eVal==$element->id) selected @endif
                @if (Input::old($eName) == $element->id) selected @endif>{{$element->namefull}}</option>
            @endforeach
        </select>
        @if ($errors->has($eName))
            <span class="help-block">
                <strong>{{ $errors->first($eName) }}</strong>
            </span>
        @endif
    </div>
</div>