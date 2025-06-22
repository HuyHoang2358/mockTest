<script>
    tinymce.init({
        selector: 'textarea.content-editor',
        plugins: 'anchor autolink  image link lists media searchreplace table wordcount',
        toolbar: 'undo redo | blocks | bold italic underline strikethrough | image table | align numlist bullist',
        menubar: false,
        height: 300, // chiều cao ban đầu ~2 dòng
        content_style: "body { line-height: 0.5; }"
    });
</script>
