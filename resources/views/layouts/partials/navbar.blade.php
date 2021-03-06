<div class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="/"><img src="{{ asset('images/logos/incentives.png') }}" alt="{{ config('app.name', 'Laravel') }}"></a>
        <ul class="nav navbar-nav pull-right visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            @if(Auth::check())
                <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
            @endif
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav">
            @if(Auth::check())
                <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
            @endif
        </ul>

        <ul class="nav navbar-nav navbar-right">
            @if (Auth::guest())
                <li><a href="{{ route('login') }}">{{ __('Ingreso') }}</a></li>
                <li><a href="{{ route('register') }}">{{ __('Registro') }}</a></li>
            @else
                <li class="dropdown dropdown-user">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <avatar image="{{ Auth::user()->avatar }}" fullname="{{ Auth::user()->name }}" :size="30"></avatar>
                        {{--<img src="/limitless_1_6/layout_1/LTR/default/starters/assets/images/image.png" alt="">--}}
                        <span>{{ Auth::user()->name }}</span>
                        <i class="caret"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right">
{{--                        <li><a href="#"><i class="icon-user-plus"></i> {{ __('Mi perfil') }}</a></li>--}}
                        {{--<li><a href="#"><i class="icon-coins"></i> My balance</a></li>--}}
                        {{--<li><a href="#"><span class="badge badge-warning pull-right">58</span> <i class="icon-comment-discussion"></i> Messages</a></li>--}}
                        <li class="divider"></li>
                        <li><a href="/users/{{ Auth::user()->id }}/edit"><i class="icon-cog5"></i> {{ __('Editar perfil') }}</a></li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="icon-switch2"></i> {{ __('Salir') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</div>