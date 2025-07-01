<div class="grid grid-cols-3 h-16 bg-white items-center px-10 w-full border-b-2 border-gray-200">
    <!-- logo -->
    <div class="col-span-1">
        <a href="#">
            <span class="logo__text text-[#124d59] text-xl font-semibold ml-3"> MockTest </span>
        </a>
    </div>

    <!-- Thời gian còn lại -->
    <div class="col-span-1 flex flex-col items-center text-[#124d59]">
        <div class="text-xl font-semibold">
            <i class="fa-regular fa-hourglass-half mr-2"></i>
            <span id="time-minus">120</span>
            <span>:</span>
            <span id="time-second">00</span>
        </div>
        <p class="font-medium">Thời gian còn lại</p>
    </div>

    <!-- Phần giao diện -->
    <div class="flex text-2xl gap-3 items-center justify-end text-gray-500">
        <!-- Nút mở slide -->
        <svg id="togglePanelBtn" class="cursor-pointer" fill="#5b7188" width="28px" height="28px" viewBox="-102.4 -102.4 1228.80 1228.80" xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="0.01024"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M799.344 960.288h-736v-800h449.6l64.704-62.336-1.664-1.664H63.344c-35.344 0-64 28.656-64 64v800c0 35.344 28.656 64 64 64h736c35.344 0 64-28.656 64-64V491.632l-64 61.088v407.568zM974.224 41.44C945.344 13.76 913.473-.273 879.473-.273c-53.216 0-92.032 34.368-102.592 44.897-14.976 14.784-439.168 438.353-439.168 438.353-3.328 3.391-5.76 7.535-7.008 12.143-11.488 42.448-69.072 230.992-69.648 232.864-2.976 9.664-.32 20.193 6.8 27.217a26.641 26.641 0 0 0 18.913 7.84c2.752 0 5.52-.4 8.239-1.248 1.952-.656 196.496-63.569 228.512-73.12 4.224-1.248 8.048-3.536 11.216-6.624 20.208-19.936 410.112-403.792 441.664-436.384 32.624-33.664 48.847-68.657 48.223-104.097-.591-35.008-17.616-68.704-50.4-100.128zm-43.791 159.679c-17.808 18.368-157.249 156.16-414.449 409.536l-19.68 19.408c-29.488 9.12-100.097 31.808-153.473 49.024 17.184-56.752 37.808-125.312 47.008-157.743C444.8 466.464 808.223 103.6 822.03 89.968c2.689-2.689 27.217-26.257 57.44-26.257 17.153 0 33.681 7.824 50.465 23.92 20.065 19.248 30.4 37.744 30.689 55.024.32 17.792-9.84 37.456-30.191 58.464z"></path></g></svg>

        <!-- Slide panel -->
        <div id="slidePanel"
             class="fixed top-[68px] right-0 w-96 h-[calc(100vh-68px)] bg-white shadow-lg transform translate-x-full transition-transform duration-500 ease-in-out z-50 flex-1 overflow-y-auto">
            <div class="flex justify-between items-center p-4 border-b px-10">
                <h2 class="text-2xl font-semibold text-[#124d59]">Nodepad</h2>
                <button id="closePanelBtn" class="text-gray-500 hover:text-red-500 text-2xl">&times;</button>
            </div>

            <!-- Ô tìm kiếm -->
            <div class="p-4">
                <div class="relative w-full">
                    <input type="text" placeholder="Tìm kiếm note"
                           class="w-full pl-4 pr-12 py-2 rounded-full border border-[#124d59] focus:outline-none focus:ring-2 focus:ring-[#124d59]"/>
                    <i class="fa-solid fa-magnifying-glass text-lg absolute top-[11px] right-4 text-[#124d59] cursor-pointer"></i>
                </div>
            </div>

            <!-- Nội dung -->
            <div id="noteContainer" class="px-5 overflow-y-auto h-[calc(100vh-143px-64px)]">
                <div class="p-2 border-gray-200 border-b">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium underline hover:text-red-500 cursor-pointer">Add</h3>

                        <!-- Dropdown -->
                        <div class="relative inline-block text-left">
                            <button class="toggleMenu text-[#5b7188] w-8 text-xl hover:text-[#124d59] focus:outline-none">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <div class="dropdownMenu absolute right-0 w-40 bg-white border border-gray-200 rounded-md shadow-lg p-2 space-y-2 z-50 hidden transition-all duration-300 ease-in-out">
                                <!-- Nút sửa -->
                                <button class="editBtn flex items-center w-full gap-2 px-2 py-1 rounded hover:bg-gray-100 text-sm text-gray-700">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 20H20.5M18 10L21 7L17 3L14 6M18 10L8 20H4V16L14 6M18 10L14 6" stroke="#5b7188" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg> Sửa
                                </button>
                                <!-- Nút xóa -->
                                <button class="deleteBtn flex items-center w-full gap-2 px-2 py-1 rounded hover:bg-gray-100 text-sm text-gray-700">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 12V17" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M14 12V17" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M4 7H20" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>Xóa
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Nội dung gốc -->
                    <p class="displayText text-base text-gray-500 mt-2">xin chao</p>

                    <!-- Khu vực sửa -->
                    <div class="editArea space-y-2 mt-2 hidden">
                        <input type="text" class="editInput w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-[#124d59]" />
                        <div class="flex gap-2 justify-end text-sm">
                            <button class="px-4 py-1 border rounded text-gray-600 hover:bg-gray-100">Hủy</button>
                            <button class="px-4 py-1 bg-[#124d59] text-white rounded hover:bg-[#0e3f47]">Lưu</button>
                        </div>
                    </div>
                    <!-- Xác nhận xóa -->
                    <div class="confirmDelete hidden bg-gray-200 px-5 py-1 mt-2 rounded-xl">
                        <div class="flex justify-between items-center text-sm text-center">
                            <p class="font-medium text-gray-600">Bạn có muốn xóa?</p>
                            <div class="flex">
                                <button class="confirmYes px-3 py-1 hover:bg-red-600 hover:text-white rounded">Có</button>
                                <button class="confirmNo px-3 py-1 hover:bg-gray-400 rounded">Không</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2 border-gray-200 border-b">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium underline hover:text-red-500 cursor-pointer">Add</h3>

                        <!-- Dropdown -->
                        <div class="relative inline-block text-left">
                            <button class="toggleMenu text-[#5b7188] w-8 text-xl hover:text-[#124d59] focus:outline-none">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <div class="dropdownMenu absolute right-0 w-40 bg-white border border-gray-200 rounded-md shadow-lg p-2 space-y-2 z-50 hidden transition-all duration-300 ease-in-out">
                                <!-- Nút sửa -->
                                <button class="editBtn flex items-center w-full gap-2 px-2 py-1 rounded hover:bg-gray-100 text-sm text-gray-700">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 20H20.5M18 10L21 7L17 3L14 6M18 10L8 20H4V16L14 6M18 10L14 6" stroke="#5b7188" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg> Sửa
                                </button>
                                <!-- Nút xóa -->
                                <button class="deleteBtn flex items-center w-full gap-2 px-2 py-1 rounded hover:bg-gray-100 text-sm text-gray-700">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 12V17" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M14 12V17" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M4 7H20" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>Xóa
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Nội dung gốc -->
                    <p class="displayText text-base text-gray-500 mt-2">xin chao</p>

                    <!-- Khu vực sửa -->
                    <div class="editArea space-y-2 mt-2 hidden">
                        <input type="text" class="editInput w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-[#124d59]" />
                        <div class="flex gap-2 justify-end text-sm">
                            <button class="px-4 py-1 border rounded text-gray-600 hover:bg-gray-100">Hủy</button>
                            <button class="px-4 py-1 bg-[#124d59] text-white rounded hover:bg-[#0e3f47]">Lưu</button>
                        </div>
                    </div>
                    <!-- Xác nhận xóa -->
                    <div class="confirmDelete hidden bg-gray-200 px-5 py-1 mt-2 rounded-xl">
                        <div class="flex justify-between items-center text-sm text-center">
                            <p class="font-medium text-gray-600">Bạn có muốn xóa?</p>
                            <div class="flex">
                                <button class="confirmYes px-3 py-1 hover:bg-red-600 hover:text-white rounded">Có</button>
                                <button class="confirmNo px-3 py-1 hover:bg-gray-400 rounded">Không</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2 border-gray-200 border-b">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium underline hover:text-red-500 cursor-pointer">Add</h3>

                        <!-- Dropdown -->
                        <div class="relative inline-block text-left">
                            <button class="toggleMenu text-[#5b7188] w-8 text-xl hover:text-[#124d59] focus:outline-none">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <div class="dropdownMenu absolute right-0 w-40 bg-white border border-gray-200 rounded-md shadow-lg p-2 space-y-2 z-50 hidden transition-all duration-300 ease-in-out">
                                <!-- Nút sửa -->
                                <button class="editBtn flex items-center w-full gap-2 px-2 py-1 rounded hover:bg-gray-100 text-sm text-gray-700">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 20H20.5M18 10L21 7L17 3L14 6M18 10L8 20H4V16L14 6M18 10L14 6" stroke="#5b7188" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg> Sửa
                                </button>
                                <!-- Nút xóa -->
                                <button class="deleteBtn flex items-center w-full gap-2 px-2 py-1 rounded hover:bg-gray-100 text-sm text-gray-700">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 12V17" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M14 12V17" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M4 7H20" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>Xóa
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Nội dung gốc -->
                    <p class="displayText text-base text-gray-500 mt-2">xin chao</p>

                    <!-- Khu vực sửa -->
                    <div class="editArea space-y-2 mt-2 hidden">
                        <input type="text" class="editInput w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-[#124d59]" />
                        <div class="flex gap-2 justify-end text-sm">
                            <button class="px-4 py-1 border rounded text-gray-600 hover:bg-gray-100">Hủy</button>
                            <button class="px-4 py-1 bg-[#124d59] text-white rounded hover:bg-[#0e3f47]">Lưu</button>
                        </div>
                    </div>
                    <!-- Xác nhận xóa -->
                    <div class="confirmDelete hidden bg-gray-200 px-5 py-1 mt-2 rounded-xl">
                        <div class="flex justify-between items-center text-sm text-center">
                            <p class="font-medium text-gray-600">Bạn có muốn xóa?</p>
                            <div class="flex">
                                <button class="confirmYes px-3 py-1 hover:bg-red-600 hover:text-white rounded">Có</button>
                                <button class="confirmNo px-3 py-1 hover:bg-gray-400 rounded">Không</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nút fullscreen -->
        <button id="fullscreenToggle" class="transition-all duration-300 ease-in-out">
            <!-- Icon: Enter Fullscreen -->
            <span id="enterIcon" class="block"><svg width="32px" height="32px" viewBox="0 0 24 24" fill="#5b7188" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4.75 9.233C4.75 9.64721 5.08579 9.983 5.5 9.983C5.91421 9.983 6.25 9.64721 6.25 9.233H4.75ZM6.25 5.5C6.25 5.08579 5.91421 4.75 5.5 4.75C5.08579 4.75 4.75 5.08579 4.75 5.5H6.25ZM5.5 4.75C5.08579 4.75 4.75 5.08579 4.75 5.5C4.75 5.91421 5.08579 6.25 5.5 6.25V4.75ZM9.233 6.25C9.64721 6.25 9.983 5.91421 9.983 5.5C9.983 5.08579 9.64721 4.75 9.233 4.75V6.25ZM6.03033 4.96967C5.73744 4.67678 5.26256 4.67678 4.96967 4.96967C4.67678 5.26256 4.67678 5.73744 4.96967 6.03033L6.03033 4.96967ZM9.96967 11.0303C10.2626 11.3232 10.7374 11.3232 11.0303 11.0303C11.3232 10.7374 11.3232 10.2626 11.0303 9.96967L9.96967 11.0303ZM15.767 18.75C15.3528 18.75 15.017 19.0858 15.017 19.5C15.017 19.9142 15.3528 20.25 15.767 20.25V18.75ZM19.5 20.25C19.9142 20.25 20.25 19.9142 20.25 19.5C20.25 19.0858 19.9142 18.75 19.5 18.75V20.25ZM18.75 19.5C18.75 19.9142 19.0858 20.25 19.5 20.25C19.9142 20.25 20.25 19.9142 20.25 19.5H18.75ZM20.25 15.767C20.25 15.3528 19.9142 15.017 19.5 15.017C19.0858 15.017 18.75 15.3528 18.75 15.767H20.25ZM18.9697 20.0303C19.2626 20.3232 19.7374 20.3232 20.0303 20.0303C20.3232 19.7374 20.3232 19.2626 20.0303 18.9697L18.9697 20.0303ZM15.0303 13.9697C14.7374 13.6768 14.2626 13.6768 13.9697 13.9697C13.6768 14.2626 13.6768 14.7374 13.9697 15.0303L15.0303 13.9697ZM6.25 15.767C6.25 15.3528 5.91421 15.017 5.5 15.017C5.08579 15.017 4.75 15.3528 4.75 15.767H6.25ZM4.75 19.5C4.75 19.9142 5.08579 20.25 5.5 20.25C5.91421 20.25 6.25 19.9142 6.25 19.5H4.75ZM5.5 18.75C5.08579 18.75 4.75 19.0858 4.75 19.5C4.75 19.9142 5.08579 20.25 5.5 20.25V18.75ZM9.233 20.25C9.64721 20.25 9.983 19.9142 9.983 19.5C9.983 19.0858 9.64721 18.75 9.233 18.75V20.25ZM4.96967 18.9697C4.67678 19.2626 4.67678 19.7374 4.96967 20.0303C5.26256 20.3232 5.73744 20.3232 6.03033 20.0303L4.96967 18.9697ZM11.0303 15.0303C11.3232 14.7374 11.3232 14.2626 11.0303 13.9697C10.7374 13.6768 10.2626 13.6768 9.96967 13.9697L11.0303 15.0303ZM15.767 4.75C15.3528 4.75 15.017 5.08579 15.017 5.5C15.017 5.91421 15.3528 6.25 15.767 6.25V4.75ZM19.5 6.25C19.9142 6.25 20.25 5.91421 20.25 5.5C20.25 5.08579 19.9142 4.75 19.5 4.75V6.25ZM20.25 5.5C20.25 5.08579 19.9142 4.75 19.5 4.75C19.0858 4.75 18.75 5.08579 18.75 5.5H20.25ZM18.75 9.233C18.75 9.64721 19.0858 9.983 19.5 9.983C19.9142 9.983 20.25 9.64721 20.25 9.233H18.75ZM20.0303 6.03033C20.3232 5.73744 20.3232 5.26256 20.0303 4.96967C19.7374 4.67678 19.2626 4.67678 18.9697 4.96967L20.0303 6.03033ZM13.9697 9.96967C13.6768 10.2626 13.6768 10.7374 13.9697 11.0303C14.2626 11.3232 14.7374 11.3232 15.0303 11.0303L13.9697 9.96967ZM6.25 9.233V5.5H4.75V9.233H6.25ZM5.5 6.25H9.233V4.75H5.5V6.25ZM4.96967 6.03033L9.96967 11.0303L11.0303 9.96967L6.03033 4.96967L4.96967 6.03033ZM15.767 20.25H19.5V18.75H15.767V20.25ZM20.25 19.5V15.767H18.75V19.5H20.25ZM20.0303 18.9697L15.0303 13.9697L13.9697 15.0303L18.9697 20.0303L20.0303 18.9697ZM4.75 15.767V19.5H6.25V15.767H4.75ZM5.5 20.25H9.233V18.75H5.5V20.25ZM6.03033 20.0303L11.0303 15.0303L9.96967 13.9697L4.96967 18.9697L6.03033 20.0303ZM15.767 6.25H19.5V4.75H15.767V6.25ZM18.75 5.5V9.233H20.25V5.5H18.75ZM18.9697 4.96967L13.9697 9.96967L15.0303 11.0303L20.0303 6.03033L18.9697 4.96967Z"></path> </g></svg></span>
            <!-- Icon: Exit Fullscreen -->
            <svg id="exitIcon" class="hidden" xmlns="http://www.w3.org/2000/svg" width="29px" height="29px" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 15l6 6m-6-6v4.8m0-4.8h4.8"></path> <path d="M9 19.8V15m0 0H4.2M9 15l-6 6"></path> <path d="M15 4.2V9m0 0h4.8M15 9l6-6"></path> <path d="M9 4.2V9m0 0H4.2M9 9L3 3"></path> </g></svg>
        </button>

        <!-- Các nút khác -->
        <svg width="32px" height="32px" viewBox="0 0 24 24" fill="#5b7188" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 6H20M4 12H20M4 18H20" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
        <div id="openPreview" class="flex gap-2 font-medium items-center rounded-full border border-gray-600 px-5 py-1 text-lg cursor-pointer">
            <i class="fa-solid fa-list-check"></i>
            <p>Review</p>
        </div>
        <div class="flex gap-2 items-center rounded-full border border-gray-600 px-5 py-1 text-lg bg-[#124d59] text-white">
            <p>Submit</p>
            <i class="fa-solid fa-paper-plane text-sm"></i>
        </div>

        <!-- Modal Preview -->
        <div id="preview_modal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div id="modalContent" class="bg-white p-12 rounded-2xl shadow-lg w-[1200px] relative transition-all duration-300 transform opacity-0 translate-y-10">
                <!-- Close Button (X) -->
                <button class="closePreview absolute duration-150 text-3xl top-5 right-8 text-gray-500 hover:text-gray-700">
                    &times;
                </button>

                <h2 class="text-3xl font-medium mb-2 text-center text-[#124d59]">Bảng xem qua đáp án</h2>
                <p class="text-sm mb-4 text-center text-light-gray">* Đây chỉ là bảng xem qua đáp án của bạn, không thể thay đổi đáp án ở đây</p>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border border-gray-400 border-collapse">
                        <tbody>
                        <script>
                            let html = '';
                            for (let i = 1; i <= 40; i++) {
                                if ((i - 1) % 4 === 0) html += '<tr>';
                                html += `
                              <td class="border text-[18px] font-medium border-gray-300 px-5 py-2 align-middle">
                                Q${i}:
                              </td>`;
                                if (i % 4 === 0) html += '</tr>';
                            }
                            document.write(html);
                        </script>
                        </tbody>
                    </table>
                </div>
                <div class="closePreview flex w-full justify-center mt-10"><button class="text-center font-medium text-white bg-[#124d59] w-fit px-12 py-2 rounded-full text-lg hover:scale-105">Đóng</button></div>
            </div>
        </div>
    </div>

    <!-- Popup khi bôi đen -->
    <div id="selectionPopup" class="hidden absolute z-50 bg-white border border-gray-300 rounded shadow-md px-3 py-2 text-sm space-x-4
     after:content-[''] after:absolute after:bottom-[-6px] after:left-1/2 after:-translate-x-1/2
     after:border-x-8 after:border-x-transparent
     after:border-t-8 after:border-t-white after:z-[-1]">
        <button id="popupNote" class="text-blue-600 hover:underline">Note</button>
        <button id="popupHighlight" class="text-yellow-600 hover:underline">Highlight</button>
    </div>

    <!-- Popup xóa highlight -->
    <div id="deleteHighlight" class="hidden absolute z-50 bg-white border border-gray-300 rounded shadow-md px-3 py-2 text-sm space-x-4
            after:content-[''] after:absolute after:top-full after:left-1/2 after:-translate-x-1/2
            after:border-x-8 after:border-x-transparent
            after:border-t-8 after:border-t-white">
        <button class="text-red-600 hover:underline">Xóa Highlight</button>
    </div>

    <!-- Popup ghi chú sau khi chọn "Note" -->
    <div  id="notePopup" class="hidden absolute bg-white border border-gray-300 shadow-xl rounded-md p-4 z-50 w-64">
        <textarea id="noteTextarea" rows="3" placeholder="Ghi chú cho đoạn đã chọn..." class="w-full border rounded px-2 py-1 focus:ring-[#124d59] focus:outline-none"></textarea>
        <div class="flex justify-end gap-2 mt-2">
            <button id="cancelNote" class="px-3 py-1 border rounded text-gray-600 hover:bg-gray-100">Hủy</button>
            <button id="saveNote" class="px-3 py-1 bg-[#124d59] text-white rounded hover:bg-[#0e3f47]">Lưu</button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const slidePanel = document.getElementById('slidePanel');
            const toggleBtn = document.getElementById('togglePanelBtn');
            const closeBtn = document.getElementById('closePanelBtn');
            const mainContent = document.getElementById('mainContent'); // phần nội dung chính

            let isPanelOpen = false;

            // Toggle khi nhấn icon
            toggleBtn.addEventListener('click', () => {
                isPanelOpen = !isPanelOpen;

                if (isPanelOpen) {
                    slidePanel.classList.remove('translate-x-full');
                    mainContent.classList.add('mr-[380px]'); // đẩy nội dung qua trái đúng bằng width panel
                } else {
                    slidePanel.classList.add('translate-x-full');
                    mainContent.classList.remove('mr-[380px]');
                }
            });

            // Đóng khi nhấn dấu "×"
            closeBtn.addEventListener('click', () => {
                isPanelOpen = false;
                slidePanel.classList.add('translate-x-full');
                mainContent.classList.remove('mr-[380px]');
            });

            // Xử lý toggle dropdown menu
            document.querySelectorAll(".toggleMenu").forEach((btn) => {
                btn.addEventListener("click", function (e) {
                    e.stopPropagation();
                    const dropdown = this.nextElementSibling;
                    document.querySelectorAll(".dropdownMenu").forEach(menu => {
                        if (menu !== dropdown) menu.classList.add("hidden");
                    });
                    dropdown.classList.toggle("hidden");
                });
            });

            // Ẩn dropdown nếu click bên ngoài
            document.addEventListener("click", () => {
                document.querySelectorAll(".dropdownMenu").forEach(menu => {
                    menu.classList.add("hidden");
                });
            });

            // Xử lý "Sửa" ghi chú
            document.querySelectorAll(".editBtn").forEach(btn => {
                btn.addEventListener("click", function () {
                    const parent = this.closest(".border-b");
                    const displayText = parent.querySelector(".displayText");
                    const editArea = parent.querySelector(".editArea");
                    const input = editArea.querySelector(".editInput");

                    // Hiện khu sửa và ẩn text
                    displayText.classList.add("hidden");
                    editArea.classList.remove("hidden");

                    // Lấy nội dung text cho vào input
                    input.value = displayText.textContent.trim();
                });
            });

            // Xử lý "Lưu" ghi chú sau khi sửa
            document.querySelectorAll(".editArea button:nth-child(2)").forEach(btn => {
                btn.addEventListener("click", function () {
                    const parent = this.closest(".border-b");
                    const displayText = parent.querySelector(".displayText");
                    const input = parent.querySelector(".editInput");
                    const editArea = parent.querySelector(".editArea");

                    const newText = input.value.trim();
                    if (newText !== "") {
                        displayText.textContent = newText;
                    }

                    // Ẩn khu sửa, hiện lại văn bản
                    editArea.classList.add("hidden");
                    displayText.classList.remove("hidden");
                });
            });

            // Hủy sửa ghi chú
            document.querySelectorAll(".editArea button:nth-child(1)").forEach(btn => {
                btn.addEventListener("click", function () {
                    const parent = this.closest(".border-b");
                    parent.querySelector(".editArea").classList.add("hidden");
                    parent.querySelector(".displayText").classList.remove("hidden");
                });
            });

            // Xử lý "Xóa" ghi chú
            document.querySelectorAll(".deleteBtn").forEach(btn => {
                btn.addEventListener("click", function () {
                    const parent = this.closest(".border-b");
                    parent.querySelector(".confirmDelete").classList.remove("hidden");
                });
            });

            // Nút "Có"
            document.querySelectorAll(".confirmYes").forEach(btn => {
                btn.addEventListener("click", function () {
                    this.closest(".border-b").remove();
                });
            });

            // Nút "Không"
            document.querySelectorAll(".confirmNo").forEach(btn => {
                btn.addEventListener("click", function () {
                    this.closest(".confirmDelete").classList.add("hidden");
                });
            });

            // Hủy xóa
            document.querySelectorAll(".confirmDelete button:nth-child(2)").forEach(btn => {
                btn.addEventListener("click", function () {
                    const parent = this.closest(".border-b");
                    parent.querySelector(".confirmDelete").classList.add("hidden");
                });
            });

            // Xử lý fullscreen
            const fullscreenBtn = document.getElementById("fullscreenToggle");
            const enterIcon = document.getElementById("enterIcon");
            const exitIcon = document.getElementById("exitIcon");

            fullscreenBtn.addEventListener("click", () => {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen();
                    enterIcon.classList.add("hidden");
                    exitIcon.classList.remove("hidden");
                } else {
                    document.exitFullscreen();
                    enterIcon.classList.remove("hidden");
                    exitIcon.classList.add("hidden");
                }
            });

            // Xử lý sự kiện Preview
            const openPreview = document.getElementById('openPreview');
            const closeButtons = document.querySelectorAll('.closePreview');
            const modal = document.getElementById('preview_modal');
            const modalContent = document.getElementById('modalContent'); // thêm ID cho div content

            openPreview.addEventListener('click', function () {
                modal.classList.remove('hidden');

                requestAnimationFrame(() => {
                    modalContent.classList.remove('opacity-0', 'translate-y-10');
                    modalContent.classList.add('opacity-100', 'translate-y-0');
                });
            });
            function closeModal() {
                modalContent.classList.remove('opacity-100', 'translate-y-0');
                modalContent.classList.add('opacity-0', 'translate-y-10');

                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
            closeButtons.forEach(button => {
                button.addEventListener('click', closeModal);
            });
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

            // Tham chiếu đến popup đã có sẵn
            const selectionPopup = document.getElementById("selectionPopup");
            const notePopup = document.getElementById("notePopup");
            const noteTextarea = document.getElementById("noteTextarea");
            const cancelNote = document.getElementById("cancelNote");
            const saveNote = document.getElementById("saveNote");

            // Khi bôi đen văn bản
            document.addEventListener("mouseup", function (e) {
                const selection = window.getSelection();
                const text = selection.toString().trim();
                const selectionPopup = document.getElementById("selectionPopup");

                // Nếu không có text hoặc không phải là vùng chọn thật
                if (text.length === 0 || selection.rangeCount === 0) {
                    selectionPopup.classList.add("hidden");
                    return;
                }

                const range = selection.getRangeAt(0);

                // Kiểm tra nếu điểm bắt đầu hoặc kết thúc nằm trong phần đã highlight
                const startContainer = range.startContainer;
                const endContainer = range.endContainer;

                const isInsideHighlight = (node) => {
                    while (node) {
                        if (node.classList && node.classList.contains("highlightedText")) {
                            return true;
                        }
                        node = node.parentNode;
                    }
                    return false;
                };

                if (isInsideHighlight(startContainer) || isInsideHighlight(endContainer)) {
                    selectionPopup.classList.add("hidden");
                    return;
                }

                // Hiển thị popup bình thường
                const rect = range.getBoundingClientRect();
                window.currentSelectionRange = range.cloneRange();

                selectionPopup.classList.remove("hidden");
                selectionPopup.classList.add("invisible");

                const popupWidth = selectionPopup.offsetWidth;
                const popupHeight = selectionPopup.offsetHeight;

                selectionPopup.style.top = `${window.scrollY + rect.top - popupHeight - 8}px`;
                selectionPopup.style.left = `${window.scrollX + rect.left + rect.width / 2 - popupWidth / 2}px`;

                selectionPopup.classList.remove("invisible");
            });

            // Nhấn Highlight
            document.getElementById("popupHighlight").addEventListener("click", () => {
                if (window.currentSelectionRange) {
                    const span = document.createElement("span");
                    span.style.backgroundColor = "yellow";
                    span.classList.add("highlightedText", "cursor-pointer", "px-1");
                    span.textContent = window.currentSelectionRange.toString();
                    window.currentSelectionRange.deleteContents();
                    window.currentSelectionRange.insertNode(span);

                    selectionPopup.classList.add("hidden");
                    window.getSelection().removeAllRanges();
                }
            });

            // Xuất hiện popup xóa highlight
            document.addEventListener("click", function (e) {
                const highlight = e.target.closest("span.highlightedText");
                const popup = document.getElementById("deleteHighlight");

                if (highlight) {
                    e.stopPropagation();
                    const rect = highlight.getBoundingClientRect();
                    popup.classList.remove("hidden");

                    // Canh giữa popup phía trên đoạn text
                    popup.style.top = `${window.scrollY + rect.top - popup.offsetHeight - 8}px`;
                    popup.style.left = `${window.scrollX + rect.left + rect.width / 2 - popup.offsetWidth / 2}px`;

                    // Lưu lại đoạn được click để xóa sau
                    window.currentHighlightedSpan = highlight;
                } else {
                    popup.classList.add("hidden");
                }
            });

            // Xóa highlight khi nhấn nút trong popup
            document.querySelector("#deleteHighlight button").addEventListener("click", () => {
                const span = window.currentHighlightedSpan;
                if (span) {
                    const textNode = document.createTextNode(span.textContent);
                    span.parentNode.replaceChild(textNode, span);
                    document.getElementById("deleteHighlight").classList.add("hidden");
                    window.currentHighlightedSpan = null;
                }
            });

            // Nhấn Note
            document.getElementById("popupNote").addEventListener("click", (e) => {
                e.stopPropagation();

                const rect = window.currentSelectionRange.getBoundingClientRect();

                // Tạm hiển thị popup để lấy kích thước
                notePopup.classList.remove("hidden");
                notePopup.classList.add("invisible");

                const popupWidth = notePopup.offsetWidth;
                const popupHeight = notePopup.offsetHeight;

                // Đặt vị trí: bên dưới và giữa vùng bôi đen
                notePopup.style.top = `${window.scrollY + rect.bottom + 8}px`;
                notePopup.style.left = `${window.scrollX + rect.left + rect.width / 2 - popupWidth / 2}px`;

                // Hiển thị thực sự
                notePopup.classList.remove("invisible");
                notePopup.classList.remove("hidden");

                // Ẩn popup lựa chọn
                selectionPopup.classList.add("hidden");
            });

            // Hủy ghi chú
            cancelNote.addEventListener("click", () => {
                notePopup.classList.add("hidden");
                noteTextarea.value = "";
                window.getSelection().removeAllRanges();
            });

            // Lưu ghi chú
            saveNote.addEventListener("click", () => {
                const text = noteTextarea.value.trim();
                if (window.currentSelectionRange && text !== "") {
                    const selectedText = window.currentSelectionRange.toString();

                    // Bôi đen đoạn được chọn (làm nổi bật trên trang chính)
                    const span = document.createElement("span");
                    span.textContent = selectedText;
                    span.classList.add("text-red-600", "underline", "italic", "font-medium");
                    const noteId = 'note-' + Date.now(); // id duy nhất
                    span.dataset.noteId = noteId; // gán id vào span
                    window.currentSelectionRange.deleteContents();
                    window.currentSelectionRange.insertNode(span);

                    // Tạo đoạn mới chèn vào container
                    const noteContainer = document.getElementById("noteContainer");

                    const wrapper = document.createElement("div");
                    wrapper.className = "p-2 border-gray-200 border-b";

                    wrapper.innerHTML = `
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium underline hover:text-red-500 cursor-pointer" data-note-id="${noteId}">${selectedText}</h3>
                <div class="relative inline-block text-left">
                    <button class="toggleMenu text-[#5b7188] w-8 text-xl hover:text-[#124d59] focus:outline-none">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <div class="dropdownMenu absolute right-0 w-40 bg-white border border-gray-200 rounded-md shadow-lg p-2 space-y-2 z-50 hidden transition-all duration-300 ease-in-out">
                        <button class="editBtn flex items-center w-full gap-2 px-2 py-1 rounded hover:bg-gray-100 text-sm text-gray-700">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 20H20.5M18 10L21 7L17 3L14 6M18 10L8 20H4V16L14 6M18 10L14 6"
                                      stroke="#5b7188" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg> Sửa
                        </button>
                        <button class="deleteBtn flex items-center w-full gap-2 px-2 py-1 rounded hover:bg-gray-100 text-sm text-gray-700">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 12V17" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M14 12V17" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M4 7H20" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10"
                                      stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z"
                                      stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>Xóa
                        </button>
                    </div>
                </div>
            </div>
            <p class="displayText text-base text-gray-500 mt-2">${text}</p>
            <div class="editArea space-y-2 mt-2 hidden">
                <input type="text" class="editInput w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-[#124d59]" />
                <div class="flex gap-2 justify-end text-sm">
                    <button class="px-4 py-1 border rounded text-gray-600 hover:bg-gray-100">Hủy</button>
                    <button class="px-4 py-1 bg-[#124d59] text-white rounded hover:bg-[#0e3f47]">Lưu</button>
                </div>
            </div>
            <div class="confirmDelete hidden bg-gray-200 px-5 py-1 mt-2 rounded-xl">
                <div class="flex justify-between items-center text-sm text-center">
                    <p class="font-medium text-gray-600">Bạn có muốn xóa?</p>
                    <div class="flex">
                        <button class="confirmYes px-3 py-1 hover:bg-red-600 hover:text-white rounded">Có</button>
                        <button class="confirmNo px-3 py-1 hover:bg-gray-400 rounded">Không</button>
                    </div>
                </div>
            </div>
        `;

                    noteContainer.appendChild(wrapper);

                    // Ẩn popup và reset
                    notePopup.classList.add("hidden");
                    noteTextarea.value = "";
                    window.getSelection().removeAllRanges();

                    // Gán lại sự kiện cho phần tử mới thêm
                    rebindNoteEvents(wrapper);
                }
            });

            function rebindNoteEvents(wrapper) {
                const displayText = wrapper.querySelector(".displayText");
                const editArea = wrapper.querySelector(".editArea");
                const input = editArea.querySelector(".editInput");

                wrapper.querySelector(".editBtn").addEventListener("click", () => {
                    input.value = displayText.textContent.trim();
                    displayText.classList.add("hidden");
                    editArea.classList.remove("hidden");
                });

                // Lưu sửa
                editArea.querySelector("button:nth-child(2)").addEventListener("click", () => {
                    const newText = input.value.trim();
                    if (newText !== "") displayText.textContent = newText;
                    displayText.classList.remove("hidden");
                    editArea.classList.add("hidden");
                });

                // Hủy sửa
                editArea.querySelector("button:nth-child(1)").addEventListener("click", () => {
                    displayText.classList.remove("hidden");
                    editArea.classList.add("hidden");
                });

                // Xóa
                wrapper.querySelector(".deleteBtn").addEventListener("click", () => {
                    wrapper.querySelector(".confirmDelete").classList.remove("hidden");
                });

                // Có
                wrapper.querySelector(".confirmYes").addEventListener("click", () => {
                    const h3 = wrapper.querySelector("h3[data-note-id]");
                    const noteId = h3 ? h3.dataset.noteId : null;

                    // Tìm và xóa span tương ứng với noteId
                    if (noteId) {
                        const spans = document.querySelectorAll(`span[data-note-id="${noteId}"]`);
                        spans.forEach(span => {
                            // Gỡ class hoặc thay thế span bằng văn bản
                            const textNode = document.createTextNode(span.textContent);
                            span.parentNode.replaceChild(textNode, span);
                        });
                    }

                    wrapper.remove(); // Xóa note khỏi noteContainer
                });

                // Không
                wrapper.querySelector(".confirmNo").addEventListener("click", () => {
                    wrapper.querySelector(".confirmDelete").classList.add("hidden");
                });

                // Dropdown menu
                wrapper.querySelector(".toggleMenu").addEventListener("click", (e) => {
                    e.stopPropagation();
                    const dropdown = wrapper.querySelector(".dropdownMenu");
                    document.querySelectorAll(".dropdownMenu").forEach(menu => {
                        if (menu !== dropdown) menu.classList.add("hidden");
                    });
                    dropdown.classList.toggle("hidden");
                });
            }

            document.addEventListener("click", (e) => {
                // Nếu click không nằm trong popup ghi chú
                if (!notePopup.contains(e.target) && !selectionPopup.contains(e.target)) {
                    notePopup.classList.add("hidden");
                }
            });
        });


        // Xử lý sự kiện đồng hồ chạy
        const leftTime = {{$leftTime}}; // thời gian còn lại tính bằng giây
        function countdown(m) {
            let t = m; // t là thời gian còn lại tính bằng giây
            setInterval(() => {
                if (t < 0) return;
                let min = String(Math.floor(t / 60)).padStart(2, '0');
                let sec = String(t % 60).padStart(2, '0');
                document.getElementById("time-minus").textContent = min;
                document.getElementById("time-second").textContent = sec;
                t--;
            }, 1000);
        }
        countdown(leftTime);
    </script>
</div>
