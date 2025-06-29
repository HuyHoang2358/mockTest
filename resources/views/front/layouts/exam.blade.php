<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Bài thi</title>
    <link href="{{asset('assets/dist/images/logo.svg')}}" rel="admin icon">

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
    <script src="https://cdn.tiny.cloud/1/gg1e9n4g1buqmn8sl1h7l4l1q35tdtxjb9lv09mqfxwb7i7v/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    @yield('head')
</head>

<body>
    <!-- Top Bar -->
    <div class="h-screen flex flex-col justify-start">
        @include('front.partials.topExam')
        <div class="flex-grow h-full overflow-y-scroll">
            <!-- Content -->
            @yield('content')
        </div>
        @include('front.partials.bottomExam')
    </div>
</body>

</html>
