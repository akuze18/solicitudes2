<?php $headers = define_menu();?>
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        @foreach($headers as $header)
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{str_replace('.','',str_replace(' ', '', $header[0]->header))}}" aria-expanded="true">
                        <span class="glyphicon glyphicon-folder-close"></span>{{$header[0]->header}}</a>
                </h4>
            </div>
            <div id="collapse{{str_replace('.','',str_replace(' ', '', $header[0]->header))}}" class="panel-collapse collapse in">
                <div class="panel-body panel-body-menu">
                    <table class="table">
                        @foreach($header as $menu)
                            <tr>
                                <td>
                                    <span class="glyphicon {{$menu->icon_name}} text-primary"></span><a href="{{route($menu->route,$menu->parameters)}}">{{$menu->contain}}</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!--fuente= https://bootsnipp.com/snippets/featured/accordion-menu -->