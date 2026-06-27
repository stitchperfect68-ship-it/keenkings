<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Keenkings Media</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;1,400&family=Outfit:wght@300;400;500;600;700&family=Space+Mono&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('head')
</head>
<body class="admin-body">

<div class="admin-shell">
    @php $adminLogoUrl = \App\Models\SiteSetting::current()->logo_url ?? null; @endphp
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                <img src="{{ $adminLogoUrl ?? asset('images/KEEN-KINGS-LOGO WHITE.png') }}" alt="Keen Kings Media" style="height:28px;width:auto;display:block;">
                <small>ADMIN</small>
            </a>
            <button class="sidebar-collapse" id="sidebarCollapse"><i data-feather="chevrons-left"></i></button>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <span class="nav-label">Main</span>
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i data-feather="grid"></i><span>Dashboard</span>
                </a>
            </div>

            <div class="nav-section">
                <span class="nav-label">Content</span>
                <a href="{{ route('admin.hero.index') }}" class="nav-item {{ request()->routeIs('admin.hero.*') ? 'active' : '' }}">
                    <i data-feather="image"></i><span>Hero Slides</span>
                    @php $heroCount = \App\Models\HeroSlide::count(); @endphp
                    <span class="nav-badge">{{ $heroCount }}</span>
                </a>
                <a href="{{ route('admin.about.index') }}" class="nav-item {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
                    <i data-feather="info"></i><span>About</span>
                </a>
                <a href="{{ route('admin.services.index') }}" class="nav-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    <i data-feather="briefcase"></i><span>Services</span>
                </a>
                <a href="{{ route('admin.testimonials.index') }}" class="nav-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                    <i data-feather="message-square"></i><span>Testimonials</span>
                </a>
                <a href="{{ route('admin.clients.index') }}" class="nav-item {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                    <i data-feather="users"></i><span>Clients</span>
                    @php $clientCount = \App\Models\Client::count(); @endphp
                    <span class="nav-badge">{{ $clientCount }}</span>
                </a>
                <a href="{{ route('admin.process-steps.index') }}" class="nav-item {{ request()->routeIs('admin.process-steps.*') ? 'active' : '' }}">
                    <i data-feather="git-pull-request"></i><span>Process Steps</span>
                </a>
            </div>

            <div class="nav-section">
                <span class="nav-label">Portfolio</span>
                <a href="{{ route('admin.portfolio.index') }}" class="nav-item {{ request()->routeIs('admin.portfolio.*') ? 'active' : '' }}">
                    <i data-feather="layers"></i><span>All Items</span>
                </a>
                <a href="{{ route('admin.portfolio.create') }}" class="nav-item {{ request()->routeIs('admin.portfolio.create') ? 'active' : '' }}">
                    <i data-feather="plus-circle"></i><span>Add Item</span>
                </a>
            </div>

            <div class="nav-section">
                <span class="nav-label">Blog</span>
                <a href="{{ route('admin.blog.index') }}" class="nav-item {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                    <i data-feather="file-text"></i><span>All Posts</span>
                    @php $postCount = \App\Models\BlogPost::count(); @endphp
                    <span class="nav-badge">{{ $postCount }}</span>
                </a>
                <a href="{{ route('admin.blog.create') }}" class="nav-item {{ request()->routeIs('admin.blog.create') ? 'active' : '' }}">
                    <i data-feather="plus-circle"></i><span>New Post</span>
                </a>
            </div>

            <div class="nav-section">
                <span class="nav-label">Inbox</span>
                <a href="{{ route('admin.enquiries.index') }}" class="nav-item {{ request()->routeIs('admin.enquiries.*') ? 'active' : '' }}">
                    <i data-feather="mail"></i><span>Enquiries</span>
                    @php $newCount = \App\Models\ContactEnquiry::where('status','new')->count(); @endphp
                    @if($newCount > 0)<span class="nav-badge badge-red">{{ $newCount }}</span>@endif
                </a>
            </div>

            <div class="nav-section">
                <span class="nav-label">System</span>
                <a href="{{ route('admin.page-content.index') }}" class="nav-item {{ request()->routeIs('admin.page-content.*') ? 'active' : '' }}">
                    <i data-feather="layout"></i><span>Page Content</span>
                </a>
                <a href="{{ route('admin.footer.index') }}" class="nav-item {{ request()->routeIs('admin.footer.*') ? 'active' : '' }}">
                    <i data-feather="minus-square"></i><span>Footer</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i data-feather="settings"></i><span>Settings</span>
                </a>
            </div>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar">{{ strtoupper(substr(auth('admin')->user()->name, 0, 1)) }}</div>
                <div class="user-info">
                    <strong>{{ auth('admin')->user()->name }}</strong>
                    <span>{{ auth('admin')->user()->email }}</span>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="logout-btn" title="Logout"><i data-feather="log-out"></i></button>
            </form>
        </div>
    </aside>

    <!-- Main Area -->
    <div class="admin-main">
        <!-- Top Bar -->
        <header class="admin-topbar">
            <div class="topbar-left">
                <button class="mobile-menu-btn" id="mobileMenuBtn"><i data-feather="menu"></i></button>
                <div class="breadcrumb">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    @hasSection('breadcrumb')
                    <i data-feather="chevron-right"></i>
                    @yield('breadcrumb')
                    @endif
                </div>
            </div>
            <div class="topbar-right">
                <a href="{{ route('home') }}" target="_blank" class="topbar-btn" title="View Site">
                    <i data-feather="external-link"></i>
                </a>
                <button class="topbar-btn admin-theme-toggle" id="adminThemeToggle" title="Toggle Theme">
                    <i data-feather="sun" class="icon-sun"></i>
                    <i data-feather="moon" class="icon-moon"></i>
                </button>
            </div>
        </header>

        <!-- Page Content -->
        <main class="admin-content">
            @if(session('success'))
            <div class="alert alert-success" id="flashAlert">
                <i data-feather="check-circle"></i>
                {{ session('success') }}
                <button onclick="this.parentElement.remove()" class="alert-close"><i data-feather="x"></i></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-error" id="flashAlert">
                <i data-feather="alert-circle"></i>
                {{ session('error') }}
                <button onclick="this.parentElement.remove()" class="alert-close"><i data-feather="x"></i></button>
            </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
