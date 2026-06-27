<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login — Keenkings Media</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;1,400&family=Outfit:wght@400;500;600&family=Space+Mono&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
@php $loginLogo = \App\Models\SiteSetting::current()->logo_url ?? asset('images/KEEN-KINGS-LOGO WHITE.png'); @endphp
<body class="admin-login-page">

<div class="login-split">
    <div class="login-visual">
        <div class="login-visual-bg" style="background-image: url('https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=1200&q=80')"></div>
        <div class="login-visual-overlay"></div>
        <div class="login-visual-content">
            <div class="login-logo">
                <img src="{{ $loginLogo }}" alt="Keen Kings Media" style="height:52px;width:auto;display:block;margin-bottom:1rem;">
            </div>
            <p class="login-tagline">Admin Panel<br><em>Manage Your Story</em></p>
        </div>
    </div>

    <div class="login-form-side">
        <div class="login-form-wrap">
            <div style="margin-bottom:2rem;">
                <img src="{{ $loginLogo }}" alt="Keen Kings Media" style="height:44px;width:auto;display:block;">
            </div>
            <div class="login-form-header">
                <h1>Welcome Back</h1>
                <p>Sign in to the Keenkings Media admin panel</p>
            </div>

            @if(session('error'))
            <div class="alert alert-error">
                <i data-feather="alert-circle"></i>{{ session('error') }}
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="login-form">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-icon-wrap">
                        <i data-feather="mail" class="input-icon"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               placeholder="admin@keenkingsmedia.com" required autofocus>
                    </div>
                    @error('email')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-icon-wrap">
                        <i data-feather="lock" class="input-icon"></i>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                        <button type="button" class="input-toggle-pw" onclick="togglePw(this)">
                            <i data-feather="eye"></i>
                        </button>
                    </div>
                </div>

                <div class="login-options">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-full">
                    Sign In <i data-feather="arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
<script>
function togglePw(btn) {
    const inp = btn.previousElementSibling.previousElementSibling || btn.parentElement.querySelector('input');
    inp.type = inp.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>
