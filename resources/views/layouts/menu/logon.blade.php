
<div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav">

        <li @if(Route::getCurrentRoute()->uri=='/') class="active" @endif><a href="{{route('home')}}">Inicio</a></li>
        <!--<li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Solicitudes GP <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li class="dropdown-header">Creaciones</li>
                <li><a href="#">Proveedor</a></li>
                <li><a href="#">Cliente</a></li>
                <li><a href="#">Artículo</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Modificaciones</li>
                <li><a href="#">Proveedor</a></li>
                <li><a href="#">Cliente</a></li>
                <li><a href="#">Artículo</a></li>
            </ul>
        </li>-->
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <!-- Authentication Links -->
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                @foreach(Auth::user()->roles as $rol)
                    <li><a href="#"><i class="fa fa-btn fa-sign-out"></i>{{$rol->description}}</a></li>
                @endforeach
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;Cerrar Sesion
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</div>