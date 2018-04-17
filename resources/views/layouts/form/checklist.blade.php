<div class="form-group">
    <label class="col-md-4 control-label">{{trans('labels.'.$eLabel)}}</label>
    <div class="col-md-6">
        @foreach($groups as $group => $elementos)
            <div class="panel panel-default">
                @if($group!='')
                    <div class="panel-heading" id="{{$group}}">{{$group}}</div>
                @endif
                <div class="panel-body group-{{$group}}">
                    @foreach($elementos as $element)
                        <label class="checkbox-inline">

                            <?php $check = false;
                            if(isset($eVal)){
                                foreach($eVal as $sVal){
                                    if($sVal->id == $element->id){
                                        $check = true;
                                    }}}?>

                            <input class="select-{{$group}}"
                                   type="checkbox"
                                   name="{{$eName.'_'.$element->id}}"
                                   value="{{$element->id}}" {{$check?'checked':''}}>
                            {{$element->name}}
                        </label>
                    @endforeach
                </div>
            </div>
            <br>
        @endforeach
    </div>
</div>