<script>
    tinymce.init({
        selector: 'textarea.content-editor',
        plugins: 'anchor autolink  image link lists media searchreplace table wordcount preview',
        toolbar: 'undo redo | blocks | bold italic underline strikethrough | image table | align lineheight numlist bullist',
        menubar: false,
        height: 300, // chiều cao ban đầu ~2 dòng
        width: '100%',
        /*content_style: "body { line-height: 1.0; }",*/
        branding: false
    });
</script>
