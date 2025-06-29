@extends('admin.layouts.adminApp')
@section('title', 'Sửa thông tin loại câu hỏi')
@section('breadcrumb')
    <nav aria-label="breadcrumb" class="-intro-x h-[45px] mr-auto">
        <ol class="breadcrumb breadcrumb-light">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang Quản trị viên</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Quản lý file, media</a></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div>
        <iframe src="{{url('/admin/laravel-filemanager')}}" style="width: 100%; height: 600px; overflow: hidden; border: none;"></iframe>
    </div>
@endsection
