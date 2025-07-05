<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Bài thi</title>
    <link href="{{asset('assets/dist/images/logo.svg')}}" rel="admin icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- NO SEO -->
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow" />
    <meta name="bingbot" content="noindex, nofollow" />
    <meta name="robots" content="noindex, nofollow" />


    <!-- BEGIN: CSS Assets-->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('assets/dist/css/app.css')}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Font-awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <!-- END: CSS Assets-->

    <!-- BEGIN: Javascript Assets-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- TinyMCE -->
    @yield('head')
</head>

<body>
    <div class="h-screen flex flex-col justify-start">
        @include('front.partials.topExam')
        <div class="flex-grow overflow-y-auto">
            <!-- Content -->
            @yield('content')
        </div>
        @include('front.partials.bottomExam')
    </div>

    <!-- JS Assets-->
    @include('admin.components.bodyJs')

    <!-- Custom JS -->
    @yield('customJs')
</body>

</html>
