@php
      $isExpanded = in_array($folder->id, $active_ids);
      $isActive = request('folder_id') == $folder->id;
@endphp
<li>
    <div class="flex justify-between gap-2 items-center px-3 py-2 mt-2" style="padding-left: {{ $depth * 20 }}px; border-left: {{min($depth, 1)}}px solid gray">
        <div class="flex justify-start gap-2 items-center">
            @if ($folder->childrenRecursive->isNotEmpty())
                <button class="toggle-button bg-gray-200 rounded w-5 h-5 text-xs text-center flex items-center justify-center">
                    <i class="fa-solid {{ $isExpanded ? 'fa-minus' : 'fa-plus' }}"></i>
                </button>
            @else
                <div class="w-5 h-5"></div>
            @endif
            <a href="{{route('admin.folder.index').'?folder_id='.$folder->id}}" class="folder-name {{ $isActive ? 'text-primary font-semibold' : '' }}">{{ $folder->name }}</a>
        </div>
        <div class="flex justify-end gap-1 items-center">
            <!-- Thêm mới folder -->
            <button type="button"
                    class="text-green-200 hover:text-green-500 text-xs add-subfolder-btn tooltip"
                    data-id="{{ $folder->id }}"
                    data-name="{{ $folder->name }}"
                    data-tw-toggle="modal"
                    data-tw-target="#add-folder-modal"
                    data-theme="light"
                    title="Thêm thư mục con"
            >
                <i class="fa fa-plus-circle"></i>
            </button>

            <!-- Xóa folder -->
            <button type="button" data-tw-toggle="modal" data-tw-target="#delete-object-confirm-form"
                    class="text-red-200 hover:text-red-500 text-xs add-subfolder-btn tooltip"
                    data-theme="light"
                    title="Xóa thư mục"
                    onclick='openConfirmDeleteObjectForm("{{ $folder->name}}", {{ $folder->id }})'
            ><i class="fa-solid fa-trash-can"></i></button>


        </div>
    </div>

    @if ($folder->childrenRecursive->isNotEmpty())
        <ul class="{{ $isExpanded ? '' : 'hidden' }}">
            @foreach ($folder->childrenRecursive as $child)
                @include('admin.components.folder_node_ui', ['folder' => $child, 'depth' => $depth + 1, 'active_ids' => $active_ids])
            @endforeach
        </ul>
    @endif
</li>
