<div class="form-group">
    <label class="col-md-4 control-label">{{trans('labels.'.$eLabel)}}</label>
    <div class="col-md-5">
        @foreach($groups as $group => $elementos)
            <table class="table table-bordered table-responsive table-striped">
                @if($group!='')
                <thead id="{{'group-'.$group}}">
                    <tr><th> {$group}} </th></tr>
                </thead>
                @endif
                <tbody class="group-{{$group}}">
                    @foreach($elementos as $element)
                        <tr>
                            <td>
                                {{$element->name}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
        @endforeach
    </div>
</div>