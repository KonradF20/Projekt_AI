<!DOCTYPE html>
<html lang="pl">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
<body class="bg-[#FCFAF8] text-slate-800 font-sans antialiased min-h-screen relative flex flex-col selection:bg-rose-100 selection:text-rose-900">

    <x-header />

    <div class="flex-grow flex items-center justify-center">
        @yield('content')
    </div>

</body>
</html>
