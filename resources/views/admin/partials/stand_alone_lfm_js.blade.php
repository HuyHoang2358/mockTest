<script src="{{ asset('/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
<script>
    let route_prefix = "/admin/laravel-filemanager";
    $('#choose-img').filemanager('files', {prefix: route_prefix});
    $('#choose-img-secondary').filemanager('files', {prefix: route_prefix});
</script>