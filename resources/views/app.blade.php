<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HousePilot</title>

    {{-- Ensure Vite assets load properly --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    @vite(['resources/js/app.js'])
</head>
<body>
    {{-- Ensure Vue.js finds the #app element properly --}}
    <div id="app">
        <noscript>
            <strong>We're sorry but HousePilot doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
        </noscript>
    </div>

    {{-- Fix for delayed Vue mounting --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(() => {
                if (!document.getElementById('app')) {
                    console.error("Vue mount failed: #app element not found!");
                }
            }, 100);
        });
    </script>
</body>
</html>
