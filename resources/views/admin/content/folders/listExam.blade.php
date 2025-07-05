@extends('admin.layouts.adminApp')
@section('title', 'Quản lý bài thi')
@section('breadcrumb')
    <nav aria-label="breadcrumb" class="-intro-x h-[45px] mr-auto">
        <ol class="breadcrumb breadcrumb-light">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang Quản trị viên</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Quản lý bài thi</a></li>
        </ol>
    </nav>
@endsection
@section('content')

    <div class="intro-y box">
        <!-- Table title -->
        @include('admin.common.titleTable', [
            'title' => 'Danh sách bài thi',
        ])
        <!-- End Table title -->

        <!-- BEGIN: HTML Table Data -->
        <div class="intro-y col-span-12 lg:col-span-12 mt-2">
            <div class="py-2 px-4">
                <div class="overflow-x-auto">
                    <table  class="table table-hover table-bordered">
                        <thead class="table-dark">
                        <tr class=" text-center">
                            <th class="whitespace-nowrap w-8">STT</th>
                            <th class="whitespace-nowrap">Tên bài thi</th>
                            <th class="whitespace-nowrap">Tên folder</th>
                            <th class="whitespace-nowrap w-32">Code</th>
                            <th class="whitespace-nowrap w-32">Tổng thời gian</th>
                            <th class="whitespace-nowrap w-32">Thời gian bắt đầu</th>
                            <th class="whitespace-nowrap w-32">Thời gian kết thúc</th>
                            <th class="whitespace-nowrap w-32">Mật khẩu</th>
                            <th class="whitespace-nowrap w-32">Giá</th>
                            <th class="whitespace-nowrap w-32">Số lượt thi</th>
                            <th class="whitespace-nowrap text-center w-24">Thao Tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($exams) > 0)
                            @foreach ($exams as $item)
                                <tr>
                                    <td class="text-center">{{ ($exams->currentPage() - 1 ) * $exams->perPage() + $loop->index + 1 }}</td>
                                    <td>{{ $item->folder ? $item->folder->name : 'Không có thư mục' }}</td>
                                    <td>{{$item -> name}}</td>
                                    <td class="text-center">{{$item -> code}}</td>
                                    <td class="text-center">{{$item -> total_time}}</td>
                                    <td class="text-center">{{$item -> start_time}}</td>
                                    <td class="text-center">{{$item -> end_time}}</td>
                                    <td class="text-center">{{$item -> password ? '' : 'Không'}} </td>
                                    <td class="text-center">{{$item -> price}}</td>
                                    <td class="text-center">{{$item -> number_of_todo}}</td>
                                    <td>
                                        <div class="flex gap-2 justify-center items-center">
                                            <form action="{{ route('admin.user.reset', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn đặt lại mật khẩu học sinh này không?')">
                                                @csrf
                                                @method('PUT')
                                                <div class="text-center"> <a href="javascript:;" data-theme="light" class="tooltip pt-2" title="Đặt lại mật khẩu">
                                                        <button type="submit" class="btn btn-outline-success p-1 w-8 h-8">
                                                            <i class="fas fa-redo-alt mr-1"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </form>
                                            <!-- Edit button -->
                                            @include('admin.common.editButton', [
                                                'routeEdit' => route('admin.user.edit', ['id' => $item->id])
                                            ])

                                            <!-- Delete button -->
                                            @include('admin.common.deleteButton', [
                                                'deleteObjectName' => $item->name,
                                                'deleteObjectId' => $item->id
                                            ])
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="6">Hiện tại không có học sinh nào trong hệ thống. <span class="font-semibold">Vui lòng thêm mới học sinh</span></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                @if($exams->lastPage() > 1)
                    <div class="rounded-b bg-gray-100 p-2 pl-4 border">{{ $exams->appends(request()->query())->links() }}</div>
                @endif
            </div>
        </div>
    </div>

@endsection
