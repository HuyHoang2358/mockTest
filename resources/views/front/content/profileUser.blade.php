@extends('front.layouts.frontApp')
@section('title', 'Thông tin học sinh'))
@section('breadcrumb')
    <nav aria-label="breadcrumb" class="-intro-x h-[45px] mr-auto">
        <ol class="breadcrumb breadcrumb-light">
            <li class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="#">Thông tin Học sinh</a></li>
        </ol>
    </nav>
@endsection

@php($routeDelete = route('user.destroy'))

@section('content')
    <div class="grid grid-cols-12 gap-6 lg:px-32 xl:px-80">
        <!-- BEGIN: ProfileUser Menu -->
        <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse">
            <div class="intro-y box mt-5">
                <div class="relative flex items-center p-5">
                    <div class="w-12 h-12 image-fit">
                        <img alt="Avatar-mocktest" class="rounded-full" src="{{ asset(Auth::user()->profile->avatar ?? '/assets/dist/images/avatar/default/Avatar-1.png') }}">
                    </div>
                    <div class="ml-4 mr-auto">
                        <div class="font-medium text-base">{{$user->name}}</div>
                        <div class="text-slate-500">Học sinh</div>
                    </div>
                </div>
                <div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                    <a class="flex items-center text-primary font-medium" href="#"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="activity" data-lucide="activity" class="lucide lucide-activity w-4 h-4 mr-2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>Thông tin cá nhân</a>
                    <a class="flex items-center mt-5" href="#"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="box" data-lucide="box" class="lucide lucide-box w-4 h-4 mr-2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg> Cấu hình tài khoản </a>
                </div>
                <div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                    <a class="flex items-center" href="#"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="edit" data-lucide="edit" class="lucide lucide-edit w-4 h-4 mr-2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg> Danh sách bài chưa chấm </a>
                    <a class="flex items-center mt-5" href="#"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="archive" data-lucide="archive" class="lucide lucide-archive w-4 h-4 mr-2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg> Danh sách bài đã chấm </a>
                    <a class="flex items-center mt-5" href="#"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="git-branch" data-lucide="git-branch" class="lucide lucide-git-branch w-4 h-4 mr-2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg> Danh sách lớp học </a>
                </div>
            </div>
        </div>
        <!-- END: ProfileUser Menu -->

        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            <!-- BEGIN: Display Information -->
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Thông tin hiển thị
                    </h2>
                </div>
                <div class="p-5">
                    <form method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="flex xl:flex-row flex-col">
                            <div class="flex-1 mt-6 xl:mt-0">
                                <div class="flex justify-between gap-12">
                                    <div class="w-full">
                                        <label class="form-label">Tên được hiển thị</label>
                                        <input id="name" name="name" type="text" class="form-control" placeholder="Tên không được để trống" value="{{$user->name}}" required>
                                    </div>
                                    <div class="w-full">
                                        <label class="form-label">Số điện thoại</label>
                                        <input id="phone" name="phone" type="tel" class="form-control" placeholder="Số điện thoại không được để trống" value="{{$profile->phone}}" required>
                                    </div>
                                </div>
                                <div class="flex justify-between mt-3 gap-12">
                                    <div class="w-full">
                                        <label class="form-label">Google ID</label>
                                        <input id="google_id" name="google_id" type="text" class="form-control" placeholder="Không có Google ID" value="{{$profile->google_id}}" readonly>
                                    </div>
                                    <div class="w-full">
                                        <label class="form-label">Ngày sinh</label>
                                        <input id="birthday" name="birthday" type="date" class="form-control"
                                               value="{{ $profile->birthday ? \Carbon\Carbon::parse($profile->birthday)->format('Y-m-d') : '' }}">
                                    </div>
                                </div>
                                <div>
                                    <div class="mt-3">
                                        <label class="form-label">Email</label>
                                        <input id="email" name="email" type="email" class="form-control p-3" placeholder="Email không được để trống" value="{{$user->email}}" required>
                                    </div>
                                    <div class="md:hidden">
                                        <label class="form-label">Địa chỉ</label>
                                        <input id="address" name="address" type="text" class="form-control p-3" placeholder="Địa chỉ không được để trống" value="{{$profile->address}}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="w-52 mt-5 md:mt-0 mx-auto xl:mr-0 xl:ml-6">
                                <div class="border-2 border-dashed shadow-sm border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                    <div class="h-36 relative image-fit cursor-pointer hover:scale-110 ease-in-out duration-500 transition-all mx-auto group">
                                        <div class="overflow-hidden flex justify-center">
                                            <img class="w-36" src="{{ asset(Auth::user()->profile->avatar ?? '/assets/dist/images/avatar/default/Avatar-1.png') }}" alt="Avatar">
                                        </div>
                                    </div>
                                    <div class="mx-auto cursor-pointer relative mt-5">
                                        <div onclick="toggleModal(true, 'avatar_modal')" class="btn btn-primary w-full">Đổi ảnh đại diện</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="md:block hidden">
                            <label class="form-label">Địa chỉ</label>
                            <input id="address" name="address" type="text" class="form-control p-3" placeholder="Địa chỉ không được để trống" value="{{$profile->address}}" required>
                        </div>
                        <div class="mt-3 action-button-wrapper">
                            <button type="submit" class="btn btn-primary w-fit mt-3 px-4 py-2 text-base change-btn">Cập nhật</button>
                            <button type="button" class="btn btn-primary py-2 hidden changing-btn" disabled>
                                Changing <i data-loading-icon="puff" data-color="white" class="w-4 h-4 ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END: Display Information -->

            <!-- BEGIN: Change Password -->
            <div id="change-password-section" class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Thay đổi mật khẩu
                    </h2>
                </div>
                <form method="POST" action="{{ route('user.changePassword' )}}">
                    @csrf
                    @method('PUT')
                    <div class="p-5">
                        <div class="relative">
                            <label class="form-label">Mật khẩu cũ</label>
                            <input type="password" name="old_password" class="form-control" placeholder="Vui lòng nhập mật khẩu cũ" required>
                            <i class="fa-solid fa-eye toggle-password absolute top-12 right-3 -translate-y-1/2 text-gray-500 cursor-pointer"></i>
                        </div>
                        <div class="mt-3 relative">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" name="new_password" class="form-control" placeholder="Vui lòng nhập mật khẩu mới" required>
                            <i class="fa-solid fa-eye toggle-password absolute top-12 right-3 -translate-y-1/2 text-gray-500 cursor-pointer"></i>
                        </div>
                        <div class="mt-3 relative">
                            <label class="form-label">Xác nhân mật khẩu mới</label>
                            <input type="password" name="new_password_confirmation" class="form-control" placeholder="Vui lòng xác nhận mật khẩu mới" required>
                            <i class="fa-solid fa-eye toggle-password absolute top-12 right-3 -translate-y-1/2 text-gray-500 cursor-pointer"></i>
                        </div>
                        <div class="mt-3 action-button-wrapper">
                            <button type="submit" class="btn btn-primary px-4 py-2 text-base change-btn">Thay đổi</button>
                            <button type="button" class="btn btn-primary py-2 hidden changing-btn" disabled>
                                Changing <i data-loading-icon="puff" data-color="white" class="w-4 h-4 ml-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- END: Change Password -->

            <!-- BEGIN: Delete Account -->
            <div class="intro-y box mt-5">
                <div class="pt-4 pb-1 px-5">
                    <div class="flex justify-between items-center">
                        <p class="form-label text-[15px] pr-20 md:pr-0">Lưu ý: Xóa toàn bộ thông tin tài khoản của bạn, bao gồm cả bài thi, quá trình thi, xếp hạng,...</p>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản không?')">
                            @csrf
                            @method('DELETE')
                            <button data-tw-toggle="modal" data-tw-target="#delete-object-confirm-form" type="button" class="text-danger flex items-center w-32"
                                    onclick='openConfirmDeleteObjectForm("{{ $user->name }}", {{ $user->id }})'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash-2" data-lucide="trash-2" class="lucide lucide-trash-2 w-4 h-4 mr-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                Delete Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END: Delete Account -->
        </div>
    </div>

    @include('components.select_avatar')

    <script>
        document.querySelectorAll('.toggle-password').forEach(function (icon) {
            icon.addEventListener('click', function () {
                const input = this.previousElementSibling;
                const isPassword = input.type === 'password';

                input.type = isPassword ? 'text' : 'password';
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });

        document.addEventListener("DOMContentLoaded", () => {
            imageSelection('avatar_modal');
        });

        function toggleModal(show, modal_id) {
            document.getElementById(modal_id).classList.toggle("hidden");
            const body = document.body;
            if(show){
                body.style.overflow = "hidden";
            }else{
                body.style.overflow = "";
            }
        }

        function imageSelection(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;

            const images = modal.querySelectorAll(".image-selection");
            const inputField = modal.querySelector(".choosen-image"); // Select input inside the modal

            images.forEach(image => {
                image.addEventListener("click", function () {
                    // Remove selection from all images in this modal only
                    images.forEach(img => {
                        img.classList.remove("border-2");
                        img.querySelector(".choose-icon").classList.add("hidden");
                    });

                    // Add selection to the clicked image
                    this.classList.add("border-2");
                    this.querySelector(".choose-icon").classList.remove("hidden");

                    // Update the input field inside this modal
                    inputField.value = this.querySelector("img").getAttribute("value");
                });
            });
        }
        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            const scrollTarget = urlParams.get('scroll');
            if (scrollTarget === 'password') {
                const section = document.getElementById("change-password-section");
                if (section) {
                    section.scrollIntoView({ behavior: "smooth" });
                }
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.change-btn');

            buttons.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    const wrapper = btn.closest('.action-button-wrapper');
                    const form = btn.closest('form');
                    const loadingBtn = wrapper.querySelector('.changing-btn');

                    // Ẩn nút gốc, hiện loading
                    btn.disabled = true;
                    btn.classList.add('cursor-not-allowed', 'opacity-70', 'hidden');

                    if (loadingBtn) {
                        loadingBtn.classList.remove('hidden');
                    }

                    // Submit form tương ứng
                    if (form) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
