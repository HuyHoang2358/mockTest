@extends('front.layouts.authApp')
@section('title', 'Đăng nhập')
@section('content')
    <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
        <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                    Đăng nhập
                </h2>
                <div class="text-danger text-sm mt-2">
                    <ul class="pl-2 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>- {{$error}}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>

                <div class="intro-x mt-8">
                    <!-- Email Address -->
                    <input name="email" type="email" class="intro-x login__input form-control py-3 px-4 block" placeholder="Email" value="{{ old('email') }}" required autofocus>

                    <!-- Password -->
                    <div class="relative w-full">
                        <input name="password" id="password" type="password" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Mật khẩu" required>
                        <button type="button" id="togglePassword" class="absolute right-2 top-2 z-50 toggle-show-password text-lg text-primary">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>


                <!-- Remember Me -->
                <div class="intro-x flex text-slate-600 dark:text-slate-500 text-xs sm:text-sm mt-4">
                    <div class="flex items-center mr-auto">
                        <input name="remember" id="remember-me" type="checkbox" class="form-check-input border mr-2">
                        <label class="cursor-pointer select-none" for="remember-me">Nhớ đăng nhập</label>
                    </div>
                    <a href="#">Quên mật khẩu</a>
                </div>
                <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                    <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Đăng nhập</button>
                    <a href="{{route('register')}}">
                        <button type="button" class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Tạo tài khoản</button>
                    </a>
                </div>

            </form>

            <!-- Social Login -->
            <div class="mt-4">
                <div class="flex w-full items-center gap-2 text-light-gray">
                    <div class="w-full h-[1px] bg-[#D9D9D9]"></div>
                    <p>Hoặc</p>
                    <div class="w-full h-[1px] bg-[#D9D9D9]"></div>
                </div>
                <!-- Social Login Form -->
                <div id="social-login-form" class="flex gap-3 text-light-gray mt-4">
                    <form id="sign-on-google" method="GET" action="#" class="w-full">
                        <input class="role" name="role" type="text" hidden="">
                        <input type="hidden" name="redirect" value="#">
                        <button type="submit" class="w-full flex gap-2 hover:scale-105 transition-transform shadow-[0px_1px_5.3px_rgba(0,0,0,0.3)] py-2 px-10 rounded-lg items-center justify-center">
                            <img class="max-w-6" src="{{asset('assets/dist/icons/logo-google.png')}}" alt="google-logo">
                            Đăng nhập bằng tài khoản Google
                        </button>
                    </form>
                </div>
            </div>


            <!-- Terms and Conditions -->
            <div class="intro-x mt-8 xl:mt-18 text-slate-600 dark:text-slate-500 text-center xl:text-left">
                Khi đăng nhập tài khoản, bạn đồng ý với
                <a class="text-primary dark:text-slate-200 hover:font-bold" href="">Điều khoản sử dụng</a>
                và
                <a class="text-primary dark:text-slate-200 hover:font-bold" href="">Chính sách bảo mật</a>
            </div>
        </div>
    </div>
@endsection
@section('bodyJs')
    <script>
        const toggle = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        let show = false;

        toggle.addEventListener('click', function () {
            show = !show;
            password.type = show ? 'text' : 'password';
            toggle.innerHTML = show ? '<i class="fa-solid fa-eye-slash"></i>' : ' <i class="fa-solid fa-eye"></i>';
        });
    </script>
@endsection
