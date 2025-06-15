@extends('admin.layouts.authApp')
@section('title', 'Đăng nhập')
@section('content')
    <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
        <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf
                <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                    Đăng nhập
                </h2>
                <div class="text-danger text-sm mt-2">
                    <ul class="pl-2">
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
                    <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Đăng nhập</button>
                    <button class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top" disabled>Tạo tài khoản</button>
                </div>
                <div class="intro-x mt-10 xl:mt-24 text-slate-600 dark:text-slate-500 text-center xl:text-left"> By signin up, you agree to our <a class="text-primary dark:text-slate-200" href="">Terms and Conditions</a> & <a class="text-primary dark:text-slate-200" href="">Privacy Policy</a> </div>
            </form>
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
