<!-- Thông báo thành công với key success  -->
@if (Session::has('success'))
    <!-- set time to hidden alert -->
    <script>
        setTimeout(function() {
            document.querySelector('.success-msg').style.display = 'none';
        }, 3000); // 3 seconds
    </script>
    <div
        class="alert alert-dismissible success-msg show flex items-center right-80 mr-8  mt-1 fixed bg-green-700 text-white"
        role="alert"
        style="z-index: 9999; top: 6.75rem;"
    >
        <i data-lucide="thumbs-up" class="w-4 h-4 mr-2"></i>{{ Session::get('success') }}
        <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
@endif

<!-- Thông báo thất bai với key error  -->
@if (Session::has('error'))
    <div
        class="alert alert-dismissible show flex items-center mb-2 fixed right-80 mr-8  bg-red-700 text-white"
        role="alert"
        style="z-index: 9999; top: 6.75rem;"
    >
        <i data-lucide="thumbs-down" class="w-4 h-4 mr-2"></i> {{ Session::get('error') }}
        <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
@endif

<!-- Thông báo cảnh báo với key info  -->
@if (Session::has('info'))
    <div
        class="alert alert-warning alert-dismissible show flex items-center mb-2 fixed right-60"
        role="alert"
        style="z-index: 9999; top: 6.75rem;"
    >
        <i data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i> {{ Session::get('info') }}
        <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
@endif

