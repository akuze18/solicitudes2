<div class="form-group">
    <label class="col-md-4 control-label"></label>
    <div class="col-md-6">
        <label class="checkbox-inline">
            <input class=""
                   type="checkbox"
                   name="{{$eName}}"
                   value="{{$eVal}}" {{isset($check)?'checked':''}}>
            {{trans('labels.'.$eLabel)}}
        </label>
    </div>
</div>