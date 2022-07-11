<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('admin')  }}">
		<div class="sidebar-brand-icon">
			<img src="{{ URL::asset('/images/logoCircle.png') }}" width="50">
		</div>
	</a>

	<hr class="sidebar-divider my-0">

	<li class="nav-item">
		<a href="/" class="nav-link">
			<i class="fas fa-arrow-left"></i><span> Yadu</span>
		</a>
	</li>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<!-- Nav Item - Dashboard -->
	<li class="nav-item {{ request()->is('admin') ? 'active' : '' }}">
		<a class="nav-link" href="{{ url('admin')  }}">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Dashboard</span></a>
	</li>

	<!-- Divider -->
	<hr class="sidebar-divider">
    <div class="sidebar-heading">
		Edit
	</div>
    <!-- Nav Item - Pages -->
    <li class="nav-item {{ request()->is('edit/*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fas fa-fw fa-language"></i>
            <span>{{__('navigation.nav_pages')}}</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Nederlands:</h6>
				<?php
					$blocked = array("formats");
                    $pages = array_map('basename',  glob(base_path().'/resources/lang/nl/*.php*'));
                ?>
				@foreach ($pages as $page)
				@if(!in_array(basename($page, '.php'), $blocked)) 
					<?php
						$pageBasename = basename($page, '.php');
						
						$currentLocale = app()->getLocale();
						App::setLocale("nl");
						$x = __($pageBasename);
						App::setLocale($currentLocale);
					?>
					@if (!is_string($x))
						<a class="collapse-item" href="{{ url('edit/nl/'.$pageBasename.'')  }}">Edit {{$pageBasename}}</a>
					@endif
				@endif
                @endforeach
                
                <h6 class="collapse-header">Engels:</h6>
                <?php
                    $pages = array_map('basename',  glob(base_path().'/resources/lang/en/*.php*'));
                ?>
				@foreach ($pages as $page)
				@if(!in_array(basename($page, '.php'), $blocked)) 
					<?php
						$pageBasename = basename($page, '.php');
						$currentLocale = app()->getLocale();
						App::setLocale("en");
						$x = __($pageBasename);
						App::setLocale($currentLocale);
					?>
					@if (!is_string($x))
						<a class="collapse-item" href="{{ url('edit/en/'.$pageBasename.'')  }}">Edit {{$pageBasename}}</a>
					@endif
				@endif
                @endforeach
            </div>
        </div>
    </li>

	<!-- Social Media -->
	<li class="nav-item {{ request()->is('admin/links') ? 'active' : '' }}">
		<a class="nav-link collapsed" href="{{ url('admin/links')  }}">
			<i class="fas fa-fw fa-share-alt"></i>
			<span>{{__('navigation.nav_socialmedia')}}</span>
		</a>
	</li>

	<!-- Divider -->
	<hr class="sidebar-divider">

	<!-- Heading -->
	<div class="sidebar-heading">
		Admin
	</div>

	<!-- Nav Item - Users -->
	<li class="nav-item {{ request()->is('admin/accounts') ? 'active' : '' }}">
		<a class="nav-link collapsed" href="{{ url('admin/accounts')  }}">
			<i class="fas fa-fw fa-users"></i>
			<span>{{__('navigation.nav_users')}}</span>
		</a>
	</li>

	<!-- Nav Item - Events -->
	<li class="nav-item {{ request()->is('admin/events') ? 'active' : '' }}">
		<a class="nav-link collapsed" href="{{ url('admin/events')  }}">
			<i class="fas fa-fw fa-calendar-week"></i>
			<span>{{__('navigation.nav_eventsS')}}</span>
		</a>
	</li>

	<!-- Nav Item - Swear words -->
	<li class="nav-item {{ request()->is('admin/prohibitedWords') ? 'active' : '' }}">
		<a class="nav-link collapsed" href="{{ url('admin/prohibitedWords')  }}">
			<i class="fas fa-fw fa-file-word"></i>
			<span>{{__('navigation.nav_swearWords')}}</span>
		</a>
	</li>

	<!-- Nav Item - suspensions -->
	<li class="nav-item {{ request()->is('admin/suspensions/ip') ? 'active' : '' }}">
		<a class="nav-link collapsed" href="/admin/suspensions/ip">
			<i class="fas fa-user-slash"></i>
			<span>{{__('navigation.nav_suspensions')}}</span>
		</a>
	</li>
	<!-- Nav Item - testimonials -->
	<li class="nav-item {{ request()->is('admin/testimonials') ? 'active' : '' }}">
		<a class="nav-link collapsed" href="/admin/testimonials">
			<i class="fas fa-comment-dots"></i>
			<span>{{__('navigation.nav_testimonials')}}</span>
		</a>
	</li>

	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>

</ul>