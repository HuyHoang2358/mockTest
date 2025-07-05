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
                            <th class="whitespace-nowrap w-4">STT</th>
                            <th class="whitespace-nowrap">Folder</th>
                            <th class="whitespace-nowrap">Tên bài thi</th>
                            <th class="whitespace-nowrap">Mã đề</th>
                            <th class="whitespace-nowrap ">Tổng thời gian</th>
                            <th class="whitespace-nowrap">Thời gian bắt đầu</th>
                            <th class="whitespace-nowrap">Thời gian kết thúc</th>
                            <th class="whitespace-nowrap">Số lượt thi</th>
                            <th class="whitespace-nowrap">Số lượng</th>
                            <th class="whitespace-nowrap text-center">Thao Tác</th>
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
                                    <td class="text-center">{{$item -> time}} phút</td>
                                    <td class="text-center">{{$item -> start_time}}</td>
                                    <td class="text-center">{{$item -> end_time}}</td>
                                    <td class="text-center">{{$item -> number_of_todo}} lượt</td>
                                    <td class="text-center">
                                        <button data-theme="light" title="Số lượng bài đã chấm"  data-placement="top" type="button"
                                            class="tooltip font-semibold {{count($item->checkedUserExamHistories) == count($item -> userExamHistories) ? 'text-green-600' : 'text-red-500'}}">
                                            {{count($item->checkedUserExamHistories)}}
                                        </button>
                                        /
                                        <button data-theme="light" title="Tổng số bài" data-placement="top"  type="button"
                                              class="tooltip  font-semibold text-green-600">
                                            {{count($item -> userExamHistories)}}
                                        </button>
                                    </td>
                                    <td>
                                        <div class="flex gap-2 justify-center items-center">
                                            <!-- Edit button -->
                                            <div data-theme="light" class="tooltip" title="Xem thông tin chi tiết">
                                                <a href="{{ route('admin.exam.detail', $item->id) }}">
                                                    <button type="button" class="btn btn-outline-success p-1 w-8 h-8">
                                                        <i class="fa-solid fa-circle-info"></i>
                                                    </button>
                                                </a>
                                            </div>
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
