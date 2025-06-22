@extends('admin.layouts.adminApp')
@section('title','Thêm mới giáo viên')
@section('breadcrumb')
    <nav aria-label="breadcrumb" class="-intro-x h-[45px] mr-auto">
        <ol class="breadcrumb breadcrumb-light">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang quản trị viên</a></li>
            <li class="breadcrumb-item"><a href="{{route('teacher.index')}}">Quản lý giáo viên</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <a href="#"> Chỉnh sửa </a>
            </li>
        </ol>
    </nav>
@endsection
@section('content')

    <!-- Title page -->
    <div class="intro-y box flex items-center mt-8">
        <h2 class="p-5 text-lg font-medium mr-auto">
            Chỉnh sửa thông tin giáo viên
        </h2>
    </div>

    <!-- Form update information -->
    <form action="{{ route('teacher.update', ["id" => $teacher->id]) }}" method="POST">
        @csrf
        <div class="intro-y box p-5 mt-2">
            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                    Thông tin giáo viên
                </div>
                <div class="mt-5">
                    <!-- Tên giáo viên -->
                    <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                        <div class="form-label xl:w-64 xl:!mr-10">
                            <div class="text-left">
                                <div class="flex items-center">
                                    <div class="font-medium">Tên giáo viên </div>
                                    <div class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">Bắt buộc</div>
                                </div>
                                <div class="leading-relaxed text-slate-500 text-xs mt-3"> Tên giáo viên không được để trống</div>
                            </div>
                        </div>
                        <div class="w-full mt-3 xl:mt-0 flex-1">
                            <input id="name" name="name" type="text" class="form-control input-with-counter"  value="{{ old('name', $teacher->name)}}" placeholder="Nhập tên giáo viên" required autofocus>
                            <div class="form-help text-right">Tối đa <span class="word-counter" input-to-count="name" max-characters="100">0</span>/ 100 ký tự</div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                        <div class="form-label xl:w-64 xl:!mr-10">
                            <div class="text-left">
                                <div class="flex items-center">
                                    <div class="font-medium"> Địa chỉ email</div>
                                    <div
                                        class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                         Bắt buộc
                                    </div>
                                </div>
                                <div class="leading-relaxed text-slate-500 text-xs mt-3"> Cung cấp email của giáo viên</div>
                            </div>
                        </div>
                        <div class="w-full mt-3 xl:mt-0 flex-1">
                            <input name="email" class="form-control p-3" value="{{ old('email', $teacher->email)}}" placeholder="Nhập địa chỉ email" required>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Buttons cancel and save -->
        <div class="flex justify-end flex-col md:flex-row gap-2 mt-5">
            <a href="{{route('teacher.index')}}">
                <button type="button" id="btn-cancle-form" class="btn py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 w-full md:w-52">Hủy</button>
            </a>
            <button type="submit" id="btn-submit-form" class="btn py-3 btn-primary w-full md:w-52 ">Lưu thông tin</button>
        </div>
    </form>

    @include('admin.partials.stand_alone_lfm_js')

    <script>
        function togglePassword() {
            const input = document.getElementById("password");
            const icon = document.getElementById("eyeIcon");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
@endsection
