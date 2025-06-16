<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Quản trị viên</title>
    <link href="{{asset('assets/dist/images/logo.svg')}}" rel="admin icon">

    <!-- NO SEO -->
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow" />
    <meta name="bingbot" content="noindex, nofollow" />
    <meta name="robots" content="noindex, nofollow" />

    <!-- BEGIN: CSS Assets-->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('assets/dist/css/app.css')}}" />
    <!-- Font-awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <!-- END: CSS Assets-->

</head>

<body class="login">
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Login Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="" class="-intro-x flex items-center pt-5">
                    <img alt="MockTest" class="w-6" src="{{asset('assets/dist/images/logo.svg')}}">
                    <span class="text-white text-lg ml-3"> MockTest </span>
                </a>
                <div class="my-auto">
                    <img alt="MockTest" class="-intro-x w-1/2 -mt-16" src="{{asset('assets/dist/images/illustration.svg')}}">
                    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                        A few more clicks to
                        <br>
                        sign in to your account.
                    </div>
                    <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Manage all your accounts in one place</div>
                </div>
            </div>
            <!-- END: Login Info -->

            <!-- BEGIN: Login Form -->
            @yield('content')
            <!-- END: Login Form -->
        </div>
    </div>


    <!-- BEGIN: Dark Mode Switcher-->
{{--    <div data-url="login-dark-login.html" class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box dark:bg-dark-2 border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">
        <div class="mr-4 text-gray-700 dark:text-gray-300">Dark Mode</div>
        <div class="dark-mode-switcher__toggle border"></div>
    </div>--}}
    <!-- END: Dark Mode Switcher-->

    <!-- Action Alerts -->
    @include('admin.components.alert')
    <!-- End Action Alerts -->

    <!-- BEGIN: JS Assets-->
    <script src="{{ asset('assets/dist/js/app.js') }}"></script>
    <!-- END: JS Assets-->
    @yield('bodyJs')
</body>
</html>
