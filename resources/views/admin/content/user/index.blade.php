@extends('admin.layouts.adminApp')
@section('title', 'Quản lý học sinh')
@section('breadcrumb')
    <nav aria-label="breadcrumb" class="-intro-x h-[45px] mr-auto">
        <ol class="breadcrumb breadcrumb-light">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Quản trị viên</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Quản lý học sinh</a></li>
        </ol>
    </nav>
@endsection


<!-- Define route for delete action -->
@php($routeDelete = route('admin.user.destroy'))

@section('content')

    <div class="intro-y box">
        <!-- Table title -->
        @include('admin.common.titleTable', [
            'title' => 'Danh sách học sinh',
            'routeAdd' => route('admin.user.create'),
            'titleButton' => 'Thêm mới học sinh',
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
                            <th class="whitespace-nowrap">Tên học sinh</th>
                            <th class="whitespace-nowrap">Email</th>
                            <th class="whitespace-nowrap">Google Id</th>
                            <th class="whitespace-nowrap w-32">Ngày tạo</th>
                            <th class="whitespace-nowrap text-center w-24">Thao Tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($users) > 0)
                            @foreach ($users as $item)
                                <tr>
                                    <td class="text-center">{{ ($users->currentPage() - 1 ) * $users->perPage() + $loop->index + 1 }}</td>
                                    <td>{{$item -> name}}</td>
                                    <td>{{$item -> email}}</td>
                                    <td>{{$item -> google_id}}</td>
                                    <td>{{$item -> created_at}}</td>
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
                @if($users->lastPage() > 1)
                    <div class="rounded-b bg-gray-100 p-2 pl-4 border">{{ $users->appends(request()->query())->links() }}</div>
                @endif
            </div>
        </div>
    </div>
@endsection

