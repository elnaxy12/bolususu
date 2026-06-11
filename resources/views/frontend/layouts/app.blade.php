<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'My App')</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/LOGO-BSL-.png') }}" type="image/png">
    {{--  Tailwind CSS  --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@300;400;500&family=Cinzel:wght@700;900&display=swap"
        rel="stylesheet" />

        <script>
            window.__AUTH__ = {{ auth()->check() && auth()->user()->role === 'customer' ? 'true' : 'false' }};
        </script>
</head>

<body>

    <!-- Navbar -->
    @include('frontend.layouts.navbar')

    <!-- Content -->
    <div>
        @yield('content')
    </div>

    <!-- Footer -->
    @include('frontend.layouts.footer')
    @stack('scripts')
    
</body>

</html>