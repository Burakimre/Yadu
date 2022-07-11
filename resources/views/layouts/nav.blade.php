<nav class="navbar navbar-expand-lg navbar-dark navbg">
    <div class="d-flex flex-grow-1">
        <div class="navbar-header">
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <a class="navbar-brand d-none d-lg-inline-block" href="/">
            <img src={{ asset('images/logoCircle.png')}} width="57" alt="logo">
        </a>
        <a href="/" class="navbar-brand d-none d-lg-inline-block logo-text nav-item nav-yadu">{{__('navigation.nav_motto')}}</a>
        <!-- Mobile logo -->
        <a class="navbar-brand-two mx-auto d-lg-none d-inline-block logo" href="/">
            <img src={{ asset('images/logoCircle.png')}} width="60" alt="logo">
        </a>
    </div>
    <div id="navbar" class="navbar-collapse collapse" aria-expanded="false">
        <ul class="nav navbar-nav ml-auto flex-nowrap">
            <li>
                <a href="/" class="nav-link m-2 nav-item nav-yadu {{ request()->is('/') ? 'active' : '' }}">{{__('navigation.nav_home')}}</a>
            </li>
            <li>
                <a href="/events"
                   class="nav-link m-2 nav-item nav-yadu {{ request()->is('events') ? 'active' : (request()->is('events/*') ? 'active' : '') }}">{{__('navigation.nav_events')}}</a>
            </li>
            @if(Auth::user())
	            <li>
	                <a href="/home" class="nav-link m-2 nav-item nav-yadu {{ request()->is('home') ? 'active' : '' }}">{{__('navigation.nav_dashboard')}}</a>
	            </li>
                @if(Auth::user()->accountRole == 'Admin')
                <li>
                    <a href="/admin" class="nav-link m-2 nav-item nav-yadu">{{__('navigation.nav_admin')}}</a>
                </li>
                @endif
	            <li>
	                <a href="/logout" class="nav-link m-2 nav-item nav-yadu">{{__('navigation.nav_logout')}}</a>
	            </li>
            @else
	            <li>
	                <a href="/login" class="nav-link m-2 nav-item nav-yadu {{ request()->is('login') ? 'active' : '' }}">{{__('navigation.nav_login')}}</a>
	            </li>
                <li>
	                <a href="/register" class="nav-link m-2 nav-item nav-yadu {{ request()->is('register') ? 'active' : '' }}">{{__('navigation.nav_register')}}</a>
	            </li>
            @endif
        </ul>
    </div>
</nav>
