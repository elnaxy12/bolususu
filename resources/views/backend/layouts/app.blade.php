<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My App')</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/LOGO-BSL-.png') }}" type="image/png">
    {{-- Tailwind CSS --}}
    @vite('resources/css/backend/dashboard.css')
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600;700&family=Cinzel:wght@500;600&display=swap"
        rel="stylesheet" />
</head>

<body>

    <!-- Sidebar -->
    @include('backend.layouts.sidebar')

    <!-- Navbar -->
    @include('backend.layouts.navbar')

    <!-- Content -->
    <div class="w-auto md:w-full">
        @yield('content')
    </div>

    @vite('resources/js/backend/dashboard.js')
</body>

</html>