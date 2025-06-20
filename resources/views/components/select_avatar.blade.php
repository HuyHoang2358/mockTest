@php use Illuminate\Support\Facades\Auth; @endphp
<!-- Modal -->
<div id="avatar_modal" class="hidden fixed px-5 md:px-0 inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" onclick="toggleModal(false, 'avatar_modal')">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-[40rem] relative" onclick="event.stopPropagation()">
        <!-- Close Button (X) -->
        <button class="absolute duration-150 text-3xl top-0 right-2 text-gray-500 hover:text-gray-700" onclick="toggleModal(false, 'avatar_modal')">
            &times;
        </button>

        <h2 class="text-lg font-bold mb-2 text-center text-full-black">Chọn ảnh đại diện</h2>
        <h2 class="text-md mb-4 text-center text-light-gray">Cá nhân hóa hồ sơ của bạn bằng cách chọn các ảnh đại diện dưới đây</h2>

        <form action="{{ route('profile.personal.change-image') }}" method="POST" class="flex flex-col gap-3">
            @csrf
            <p class="font-medium">Ảnh đại diện</p>
            @php
                $selectedAvatar = Auth::user()->profile->avatar;
            @endphp
            <div class="image-list flex gap-2 flex-wrap max-w-[620px] justify-between">
                @for($i = 1; $i < 7; $i++)
                    @php
                        $imagePath = '/assets/dist/images/avatar/default/Avatar-' . $i . '.png';
                        $isSelected = ($selectedAvatar == $imagePath);
                    @endphp
                    <div class="image-selection relative {{ $isSelected ? 'border-2' : '' }} border-blue-secondary overflow-hidden rounded-full hover:cursor-pointer w-fit hover:scale-105 transform">
                        <img width="100" height="100" src="{{ asset($imagePath) }}"
                            alt="" value="{{$imagePath}}">
                        <div class="choose-icon {{ $isSelected ? '' : 'hidden' }} absolute inset-10">
                            <i class=" fa-solid fa-circle-check text-2xl text-white opacity-80"></i>
                        </div>
                    </div>
                @endfor
            </div>
            <input name="avatar" class="choosen-image" value="{{ $selectedAvatar }}" type="text" hidden>
            <div class="flex justify-center gap-5">
                <button type="button" onclick="toggleModal(false, 'avatar_modal')" class="text-light-gray border border-light-gray bg-transparent rounded-full py-2 px-12 hover:scale-x-105 transition-transform">Thoát</button>
                <button type="submit" class="text-white rounded-full py-2 px-10 btn btn-primary hover:scale-x-105 transition-transform">Xác nhận</button>
            </div>
        </form>

    </div>
</div>
