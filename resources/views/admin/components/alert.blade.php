<!-- Thông báo thành công với key success  -->
@if (Session::has('success'))
    <!-- set time to hidden alert -->
    <script>
        setTimeout(function() {
            document.querySelector('.success-msg').style.display = 'none';
        }, 3000); // 3 seconds
    </script>

    <div class="toastify on  toastify-right toastify-top success-msg" style="transform: translate(0px, 0px); top: 100px;">
        <div id="success-notification-content" class="toastify-content flex">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="check-circle" class="lucide lucide-check-circle text-success" data-lucide="check-circle"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <div class="ml-4 mr-4">
                <div class="font-medium">Thành công</div>
                <div class="text-slate-500 mt-1">{{Session::get('success')}}</div>
            </div>
        </div>
        <span class="toast-close">✖</span>
    </div>
@endif



<!-- Thông báo thất bai với key error  -->
@if (Session::has('error'))
    <div class="toastify on  toastify-right toastify-top" style="transform: translate(0px, 0px); top: 100px;">
        <div id="error-notification-content" class="toastify-content flex text-red-500" style="border:1px solid red">
            <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i>
            <div class="ml-4 mr-4">
                <div class="font-medium">Thất bại</div>
                <div class="text-slate-500 mt-1">{{Session::get('error')}}</div>
            </div>
        </div>
        <span class="toast-close">✖</span>
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

<script>
    // handle click close button
    document.querySelector('.toast-close').addEventListener('click', function() {
        document.querySelector('.toastify').style.display = 'none';
    });
</script>
