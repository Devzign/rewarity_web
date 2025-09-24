<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dealer Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white border-b border-gray-200">
        <div class="mx-auto max-w-7xl px-4 py-4 flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-800">Dealer Dashboard</h1>
            <div class="space-x-3">
                <a href="{{ route('products.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Products</a>
                <a href="{{ route('purchases.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Purchases</a>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-7xl px-4 py-8">
        @yield('content')
    </main>
</body>
</html>
