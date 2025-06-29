{{--<script src="{{ asset('/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
<script>
    let route_prefix = "/admin/laravel-filemanager";
    $('.choose-file').filemanager('files', {prefix: route_prefix});
</script>--}}

<script>
    function chooseFile(button, inputId){
        const route_prefix = "/admin/laravel-filemanager";
        const target_input = document.getElementById(inputId);

        let fileChosen = false;

        const fileManager = window.open(route_prefix + '?type=file', 'FileManager', 'width=900,height=600');
        window.SetUrl = function (items) {
            fileChosen = true;
            // set the value of the desired input to image url
            target_input.value = items.map(function (item) {
                // remove the domain from the URL if needed
                return item.url.replace(/^https?:\/\/[^\/]+/, '');
            }).join(',');

            target_input.dispatchEvent(new Event('change'));
            if (items.length >0 ) {
                button.innerHTML = `
                    <i class="fa-solid fa-paperclip"></i>
                    <span class="absolute bottom-0 left-2 bg-gray-300 text-primary rounded-full w-4 h-4 text-xs">${items.length}</span>
            `;
            }else {
                button.innerHTML = `
                    <i class="fa-solid fa-paperclip"></i>
                `;
            }
        };

        // Theo dõi trạng thái popup (cửa sổ LFM)
        const interval = setInterval(() => {
            if (fileManager.closed) {
                clearInterval(interval);
                // Nếu người dùng đóng cửa sổ mà không chọn gì
                if (!fileChosen) {
                    console.log('User closed file manager without selecting files');
                    target_input.value = ''; // Xóa giá trị của input
                    button.innerHTML = `
                        <i class="fa-solid fa-paperclip"></i>
                    `;
                }
            }
        }, 300);
    }
</script>
