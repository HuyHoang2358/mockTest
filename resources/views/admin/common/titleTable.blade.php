<div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
    <h2 class="font-medium text-xl mr-auto">
        {{ $title }}
    </h2>
    <div class="w-full sm:w-auto flex items-center gap-2 mt-4 sm:mt-0">
        <!-- BEGIN: Search -->
        <div class="intro-x relative mr-3 sm:mr-6">
            <form method="GET" action="{{ route('teacher.index') }}" class="search hidden sm:block">
                <input
                    value="{{ request('search') }}"
                    name="search"
                    id="search-input"
                    type="text"
                    class="border border-light-gray rounded-lg w-64 pr-10 h-12 focus:border-none focus:outline-none focus:border-[#124d59] !focus:ring-[#124d59]"
                    placeholder="Tên tài khoản hoặc email"
                >
                <button type="submit" id="search-button" class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <i class="fa fa-search text-[#124d59]" id="search-icon"></i>
                    <svg id="loading-spinner" class="animate-spin hidden ml-2 h-5 w-5 text-[#124d59]"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8h4z"></path>
                    </svg>
                </button>
            </form>

            <button class="notification notification--light sm:hidden hover:cursor-pointer">
                <i class="fa fa-search notification__icon dark:text-slate-500"></i>
            </button>
        </div>
        <!-- END: Search -->

        @if (isset($routeAdd))
            @if (request()->has('search'))
                <a href="{{ route('teacher.index') }}">
                    <button type="button" class="btn btn-primary w-fit h-12">
                        Xem toàn bộ
                    </button>
                </a>
            @endif
            <a href="{{ $routeAdd }}">
                <button type="button" class="btn btn-primary w-56 h-12">
                    <i data-lucide="plus"></i> {{ $titleButton }}
                </button>
            </a>
        @endif

        <div class="dropdown ml-auto sm:ml-0">
            <button class="dropdown-toggle btn px-2 box bg-gray-500 shadow" aria-expanded="false"
                data-tw-toggle="dropdown">
                <span class="w-7 h-7 flex items-center justify-center"><i data-lucide="printer"></i></span>
            </button>
            <div class="dropdown-menu w-40">
                <ul class="dropdown-content">
                    <li><a href="#" class="dropdown-item"> In </a></li>
                    <li><a href="{{ route('teacher.export', request()->query()) }}" class="dropdown-item"> Xuất file excel</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("form.search");
        const spinner = document.getElementById("loading-spinner");
        const icon = document.getElementById("search-icon");

        if (form) {
            form.addEventListener("submit", function () {
                // Ẩn icon search, hiện spinner
                icon.classList.add("hidden");
                spinner.classList.remove("hidden");
            });
        }
    });
</script>
