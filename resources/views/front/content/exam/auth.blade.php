@extends('front.layouts.frontApp')
@section('title', 'Xác thực trước khi vào bài thi')
@section('breadcrumb')
    <nav aria-label="breadcrumb" class="-intro-x h-[45px] mr-auto">
        <ol class="breadcrumb breadcrumb-light">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="max-w-lg mx-auto mt-24 p-6 bg-white shadow rounded">
        <h2 class="text-xl font-bold text-center mb-4">Nhập mật khẩu bài thi</h2>

        <form method="POST" action="{{ route('exam.auth') }}" class="space-y-4">
            @csrf
            <div class="intro-x mt-8 space-y-4">
                <input type="text" class="intro-x login__input form-control py-3 px-4 block" placeholder="Họ và tên" name="name" required>

                <div class="relative">
                    <input id="passwordInput" type="password" class="relative intro-x login__input form-control py-3 px-4 block w-full pr-10" placeholder="Mật khẩu bài thi" name="password" required>
                    <span id="togglePassword" class="absolute inset-y-0 right-3 flex items-center cursor-pointer text-gray-600 z-50">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="flex justify-center mt-4">
                <button type="submit" class="btn btn-outline-success w-24 inline-block mr-1 mb-2">Vào bài thi</button>
            </div>
        </form>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            togglePassword.innerHTML = type === 'password'
                ? '<i class="fas fa-eye"></i>'
                : '<i class="fas fa-eye-slash"></i>';
        });
    </script>
@endsection
