<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>POS App</title>
    @vite('resources/css/app.css') <!-- si tu utilises Breeze/Tailwind -->
    @livewireStyles
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <div class="flex flex-row gap-8">
            <div class="w-2/3">
                <livewire:product-list />
            </div>
            <div class="w-1/3">
                <livewire:cart />
            </div>
        </div>
    </div>
    @livewireScripts
</body>
</html>