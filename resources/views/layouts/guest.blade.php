<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SpillPost {{ isset($title) ? ' | ' . $title : '' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen px-7 sm:px-0 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-900">
            <div>
                <a href="/">
                    <svg class="w-12 h-12 xl:w-24 xl:h-24" viewBox="0 0 55 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.2104 29.7684C15.6891 35.5154 22.9637 36.9521 27.1661 36.9521C-1.0915 49.7957 54.9889 50.0134 54.3368 41.959C53.8151 35.5154 46.5841 35.9362 43.0338 36.9521C42.686 31.9018 39.8457 28.7525 38.4691 27.8092C36.2954 25.4147 25.8619 22.5847 20.2104 29.7684Z" fill="#0CA0F3"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.6483 4.09503C13.0849 1.64866 15.791 0 18.8925 0C23.498 0 27.2316 3.63528 27.2316 8.11962C27.2316 8.71189 27.1665 9.28934 27.0428 9.84557C29.162 12.2831 30.0806 15.7093 29.2086 19.0537C27.8152 24.3978 22.3294 27.6922 16.9852 26.2987L7.55022 23.8387C2.15545 22.432 -1.07758 16.9184 0.329039 11.5237C1.64914 6.46071 6.58657 3.30175 11.6483 4.09503ZM24.1258 7.54707C23.4873 7.21646 22.803 6.95133 22.079 6.76255L14.8546 4.87888C15.8207 3.77448 17.2711 3.07227 18.8926 3.07227C21.5993 3.07227 23.8292 5.02908 24.1258 7.54707Z" fill="#FCF6F6"/>
                        <path d="M27.8899 19.3116C26.395 24.7978 26.1343 27.625 21.2652 26.3339C18.7657 25.6711 17.1369 23.0422 19.1119 15.8004C21.2652 9.65579 23.1135 8.33466 25.613 8.99743C31.84 9.65577 28.9872 13.6059 27.8899 19.3116Z" fill="black"/>
                        <path d="M31.1724 40.0071C35.9062 22.5413 24.3587 25.4891 19.7684 24.31V20.9937V16.7931C34.6152 19.0039 32.0331 25.1943 41.5006 40.0071H31.1724Z" fill="#0CA0F3" stroke="#040404"/>
                    </svg>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
