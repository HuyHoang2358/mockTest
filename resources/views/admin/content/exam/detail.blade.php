@extends('admin.layouts.adminApp')
@section('title', 'Thông tin đề thi')
@section('breadcrumb')
    <nav aria-label="breadcrumb" class="-intro-x h-[45px] mr-auto">
        <ol class="breadcrumb breadcrumb-light">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang Quản trị viên</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.folder.index').'?folder_id='.$exam->folder->id}}">{{$exam->folder->name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">{{$exam->name}}</a></li>
        </ol>
    </nav>
@endsection

@section('head')
    <style>
        td, th{
            border: 1px solid gray;
            padding: 5px;
        }
    </style>
@endsection
@section('content')
    <!-- Define route for delete action -->
    @php
        $routeDelete = route('admin.part.destroy', ['exam_id' => $exam->id])
    @endphp

    <div class="grid grid-cols-12 gap-6 mt-4">
        <!-- Left side: Exam information -->
        <div class="col-span-9">
            <!-- Part tabs -->
            <div class="flex justify-between items-center">
                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($exam->parts as $part)
                            <li id="part-{{$part->id}}-tab" class="nav-item relative flex items-center " role="presentation">
                                <button class="nav-link w-full py-3 pr-8 text-left {{$loop->index == 0 ? 'active' : ''}}" type="button" role="tab"
                                        data-tw-toggle="pill" data-tw-target="#part-{{$part->id}}"
                                        aria-controls="part-{{$part->id}}" aria-selected="true"
                                >
                                    {{$part->name}}
                                </button>
                                <button type="button" class="absolute right-1.5 top-0.5 text-gray-500 cursor-pointer hover:text-red-500 text-sm"
                                        data-tw-target="#delete-object-confirm-form" data-tw-toggle="modal"
                                      onclick="openConfirmDeleteObjectForm('{{ $part->name}}', '{{ $part->id }}')">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="">
                    <a href="{{route('admin.part.add', ['exam_id' => $exam->id])}}">
                        <button type="button" class="btn btn-primary">
                            <i class="fa-solid fa-plus mr-2"></i> Part
                        </button>
                    </a>
                </div>
            </div>

            <!-- Part content -->
            <div class="tab-content border-l border-r border-b bg-white rounded-bl-lg rounded-br-lg">
                @foreach($exam->parts as $part)
                    <div id="part-{{$part->id}}" class="tab-pane leading-relaxed p-5 {{$loop->index == 1 ? 'active' : ''}}" role="tabpanel" aria-labelledby="part-{{$part->id}}-tab">
                        <div class="flex justify-between items-center">
                            <!-- Danh sách file đính kèm -->
                            <div class="mt-2 flex justify-start items-center gap-2">
                                <button type="button" class="font-bold text-xl tooltip" data-theme="light" title="Đính kèm file">
                                    <i class="fa-solid fa-paperclip"></i>
                                </button>
                                @php
                                    $partAttachments = json_decode($part->attached_file);
                                    // remove path only keep file names
                                    if(is_array($partAttachments)){
                                        $partAttachments = array_map(function($item) {
                                            return basename($item);
                                        }, $partAttachments);
                                    } else {
                                        $partAttachments = [];
                                    }
                                @endphp
                                @if($partAttachments == '')
                                    <span> Chưa có file đính kèm</span>
                                @else
                                    <span class="flex items">{{join(",",$partAttachments)}}</span>
                                @endif
                            </div>

                            <!-- Điểm, thời gian, câu hỏi -->
                            <div class="flex justify-end items-center gap-3">
                                <!-- Tổng số câu hỏi của phần -->
                                <div class="flex justify-start items-center gap-1">
                                    <label for="part-1-number-question-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng số câu hỏi của phần">
                                        <i class="fa-regular fa-circle-question"></i>
                                    </label>
                                    <input id="part-1-number-question-input" value="{{$part->num_question}}" name="part_number_question[]" type="number" min=0 max= 100 class="w-16 form-control" disabled/>
                                </div>

                                <!-- Tổng số điểm của phần -->
                                <div class="flex justify-start items-center gap-1">
                                    <label for="part-1-total-score-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng điểm của phần (point)">
                                        <i class="fa-regular fa-file-lines"></i>
                                    </label>
                                    <input id="part-1-total-score-input"   value="{{$part->score}}" name="part_total_score[]" type="number" min=0 max= 100 class="w-20 form-control" disabled/>
                                </div>


                                <!-- Tổng thời gian làm bài của phần -->
                                <div class="flex justify-start items-center gap-1">
                                    <label for="part-1-total-time-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng thời gian làm bài (phút)">
                                        <i class="fa-regular fa-clock"></i>
                                    </label>
                                    <input id="part-1-total-time-input" name="part_total_time[]" type="number" value="{{$part->time}}" class="w-20 form-control" readonly/>
                                </div>

                            </div>
                        </div>
                        <div class="mt-4 part-content">
                            @if($part->content)
                                {!! $part->content !!}
                            @endif
                        </div>
                        <div class="part-content-detail">
                            <div class="question-group ">
                                @foreach($part->questionGroups as $questionGroup)
                                    <div class="question-group-item mt-2 border-t-4 border-primary py-2" id="question-group-{{$questionGroup->id}}">
                                        <!-- Title Question Group  -->
                                        <div class="flex justify-between items-center gap-4">
                                            <!-- Danh sách file đính kèm -->
                                            <div class="flex-grow">
                                                <h3 class="text-md font-semibold text-primary">{{$questionGroup->name}}</h3>
                                            </div>

                                            <!-- Files, Điểm, thời gian, câu hỏi -->
                                            <div class="flex justify-end items-center gap-3">
                                                <div class="mt-2 flex justify-start items-center gap-2">
                                                    @php
                                                        $questionGroupAttachments = json_decode($questionGroup->attached_file);
                                                        // remove path only keep file names
                                                        if(is_array($questionGroupAttachments)){
                                                            $questionGroupAttachments = array_map(function($item) {
                                                                return basename($item);
                                                            }, $questionGroupAttachments);
                                                        } else {
                                                            $questionGroupAttachments = [];
                                                        }
                                                    @endphp
                                                    @if($questionGroupAttachments == '')
                                                        <button type="button" class="font-bold text-xl tooltip" data-theme="light" title="Đính kèm file">
                                                            <i class="fa-solid fa-paperclip"></i>
                                                        </button>
                                                        <span> Chưa có file đính kèm</span>
                                                    @else
                                                        <span class="flex items">{{join(",",$questionGroupAttachments)}}</span>
                                                    @endif
                                                </div>

                                                <!-- Tổng số câu hỏi của nhóm câu hỏi -->
                                                <div class="flex justify-start items-center gap-1">
                                                    <label for="question-group-1-number-question-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng số câu hỏi của nhóm" >
                                                        <i class="fa-regular fa-circle-question"></i>
                                                    </label>
                                                    <input id="question-group-1-number-question-input" value="{{$questionGroup->num_question}}" name="question_group_number_question" type="number" min=0 max= 100 class="w-16 form-control" readonly/>
                                                </div>

                                                <!-- Tổng số điểm của nhóm câu hỏi -->
                                                <div class="flex justify-start items-center gap-1">
                                                    <label for="part-{{$questionGroup->id}}-total-score-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng điểm của phần (point)">
                                                        <i class="fa-regular fa-file-lines"></i>
                                                    </label>
                                                    <input id="part-{{$questionGroup->id}}-total-score-input" name="question_group_score[]" value={{$questionGroup->score}} type="number" min=0 max= 100 class="w-20 form-control" readonly/>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Content Question Group -->
                                        <div class="mt-2 pl-5 w-full content-detail">
                                            @if($questionGroup->answer_inside_content)
                                                @php
                                                $questions = $questionGroup->questions;
                                                $ans = [];
                                                foreach ($questions as $question) {
                                                    $answer = $question->answers->where('is_correct', 1)->first();
                                                    $ans[$question->number] = join(",",json_decode($answer->value));
                                                }

                                                $newContent =  preg_replace_callback('/\[(\d+)\]/', function ($matches) use ($ans) {
                                                    $number = $matches[1];
                                                    return '
                                                        <button type="button" for="answers[' . $number . ']" class="btn btn-primary font-bold text-md w-6 h-6 rounded-full text-center">' . $number . '</button>
                                                        <input type="text" name="answers[' . $number . ']" value="'.$ans[$number].'" class="form-control form-control-sm small w-32 ml-2" readonly/>
                                                    ';
                                                }, $questionGroup->content);
                                                @endphp


                                                {!! $newContent !!}
                                            @else
                                                {!! $questionGroup->content !!}
                                                @foreach($questionGroup->questions as $question)
                                                    <div class="question-item border rounded p-3 my-3 flex justify-start items-start gap-2" id="question-{{$question->id}}">
                                                        <!-- Nội dung câu hỏi -->
                                                        <div class="flex-grow">
                                                            <div class="flex justify-between items-center gap-4">
                                                                <p class="font-semibold">{{$question->name}}</p>
                                                                <div class="flex items-center gap-4">
                                                                    <!-- Loại câu hỏi -->
                                                                    <div class="flex items-center gap-1">
                                                                        <i class="fa-solid fa-bars-staggered text-primary tooltip" data-theme="light" title="Loại câu hỏi"></i>
                                                                        <input type="text" class="form-control" disabled value="{{$question->input_type}}" />
                                                                    </div>
                                                                    <!-- Điểm -->
                                                                    <div class="flex items-center gap-1">
                                                                        <i class="fa-regular fa-file-lines text-primary" title="Điểm"></i>
                                                                        <input type="number" name="total_score" min="0" max="100" value="{{$question->score}}" class="form-control w-16"  readonly/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Nội dung bên trong câu hỏi -->
                                                            <div id="question-item-{{$question->id}}" class="pl-4 mt-2">
                                                                {!! $question->content !!}
                                                                <div class="grid grid-cols-2 gap-4 mt-4">
                                                                    @foreach($question->answers as $answer)
                                                                        <div class="answer-config-item border rounded p-3 {{$answer->is_correct ? 'bg-green-200' : ''}}">
                                                                            <div class="flex justify-start items-center rounded gap-4">
                                                                                @if($answer->label)
                                                                                    <p>{{$answer->label}}</p>
                                                                                @endif
                                                                                <p>{{$answer->value}}</p>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                            @endif
                                        </div>
                                @endforeach
                            </div>
                        </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- No have parts -->
            @if($exam->parts->isEmpty())
                <div class="text-center mt-4">
                    <p class="text-gray-500">Chưa có phần nào trong đề thi này. Vui lòng thêm các phần</p>
                </div>
            @endif
        </div>
        <div class="col-span-3 box p-5">
            <h2 class="text-lg font-semibold mb-4">Thông tin đề thi, bài tập</h2>

            <div class="font-semibold flex flex-col gap-2">
                <h3 class="text-[17px] text-primary">Tên đề thi: <span class="text-gray-500 text-base font-medium">{{ $exam->folder?->name ?? 'Không có folder' }}</span></h3>
                <h3 class="text-[17px] text-primary">Bài thi: <span class="text-gray-500 text-base font-medium">{{ $exam->name }}</span></h3>
                <h3 class="text-[17px] text-primary">Mật khẩu: <span class="text-gray-500 text-base font-medium">{{ $exam->password ?? 'Không có mật khẩu' }}</span></h3>
                <h3 class="text-[17px] text-primary">Giá: <span class="text-gray-500 text-base font-medium">{{ $exam->price }} đ</span></h3>
                <h3 class="text-[17px] text-primary">Số lần thi: <span class="text-gray-500 text-base font-medium">{{ $exam->number_of_todo }}</span></h3>
                <h3 class="text-[17px] text-primary">Thời gian bắt đầu: <span class="text-gray-500 text-base font-medium">{{ $exam->start_time }}</span></h3>
                <h3 class="text-[17px] text-primary">Thời gian kết thúc: <span class="text-gray-500 text-base font-medium">{{ $exam->end_time }}</span></h3>
            </div>

            <div  class="rounded-full mt-10 pt-2 pb-4" style="border: 1px dashed; border-image: repeating-linear-gradient(45deg, #9ca3af 0, #9ca3af 6px, transparent 6px, transparent 12px) 1;">
                <div class="intro-y">
                    <div class="box p-2">
                        <ul class="nav nav-pills" role="tablist">
                            <li id="ticket-tab" class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#ticket" type="button" role="tab" aria-controls="ticket" aria-selected="true"> Kiểm tra </button>
                            </li>
                            <li id="details-tab" class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#details" type="button" role="tab" aria-controls="details" aria-selected="false"> Luyện tập </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="ticket" class="tab-pane active px-2" role="tabpanel" aria-labelledby="ticket-tab" style="width: 334px;">
                        <div class="grid grid-cols-5 mt-3">
                            <div class="col-span-2 flex flex-col items-center">
                                <div>
                                    @if ($exam->qr_code_excer)
                                        <img id="qrImage" class="w-24" src="{{ $exam->qr_code_excer }}" alt="QR Code của bài kiểm tra" />
                                    @endif
                                </div>
                                <div class="flex flex-col items-center gap-2 pt-3 text-[#124d59] cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" x2="12" y1="15" y2="3"></line></svg>
                                    <p onclick="downloadQR()" class="text-sm">Tải xuống mã QR</p>
                                </div>
                            </div>
                            <div class="col-span-3 text-center font-medium text-[#124d59] text-base pt-2">
                                <p>Hoặc<br><span class="text-gray-500 ">Copy link bên dưới để tham gia bài kiểm tra</span></p>
                                <div id="copySourceExcer" class="text-gray-400 text-sm py-2">
                                    @if ($exam->url_excer)
                                        <p id="copySource" class=" truncate overflow-hidden whitespace-nowrap">
                                            <a href="{{ $exam->url_excer }}" target="_blank">{{ $exam->url_excer }}</a>
                                        </p>
                                    @endif
                                </div>
                                <button onclick="copyURL('copySourceExcer')" class="border-2 border-[#129eaf] rounded-xl font-medium px-7 py-1 cursor-pointer"> Sao chép </button>
                            </div>
                        </div>
                    </div>
                    <div id="details" class="tab-pane px-2" role="tabpanel" aria-labelledby="details-tab" style="">
                        <div class="grid grid-cols-5 mt-3">
                            <div class="col-span-2 flex flex-col items-center">
                                <div>
                                    @if ($exam->qr_code_todo)
                                        <img id="qrImage" class="w-24" src="{{ $exam->qr_code_todo }}" alt="QR Code của bài luyện tập" />
                                    @endif
                                </div>
                                <div class="flex flex-col items-center gap-2 pt-3 text-[#124d59] cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" key="ih7n3h"></path><polyline points="7 10 12 15 17 10" key="2ggqvy"></polyline><line x1="12" x2="12" y1="15" y2="3" key="1vk2je"></line></svg>
                                    <p onclick="downloadQR()" class="text-sm">Tải xuống mã QR</p>
                                </div>
                            </div>
                            <div class="col-span-3 text-center font-medium text-[#124d59] text-base pt-2">
                                <p>Hoặc<br><span class="text-gray-500 ">Copy link bên dưới để tham gia bài luyện tập</span></p>
                                <div id="copySourceTodo" class="text-gray-400 text-sm py-2">
                                    @if ($exam->url_todo)
                                        <p id="copySource" class=" truncate overflow-hidden whitespace-nowrap">
                                            <a href="{{ $exam->url_todo }}" target="_blank">{{ $exam->url_todo }}</a>
                                        </p>
                                    @endif
                                </div>
                                <button onclick="copyURL('copySourceTodo')" class="border-2 border-[#129eaf] rounded-xl font-medium px-7 py-1 cursor-pointer"> Sao chép </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sao chép URL và tải xuống mã QR
        function copyURL(id) {
            const anchor = document.querySelector(`#${id} a`);
            if (!anchor) {
                alert("Không tìm thấy URL để sao chép");
                return;
            }

            const url = anchor.href;

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url)
                    .then(() => alert("Đã sao chép: " + url))
                    .catch(err => {
                        console.error(err);
                        fallbackCopyText(url);
                    });
            } else {
                fallbackCopyText(url);
            }
        }

        function fallbackCopyText(text) {
            const tempInput = document.createElement("input");
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            try {
                document.execCommand("copy");
                alert("Đã sao chép: " + text);
            } catch (err) {
                alert("Không thể sao chép");
            }
            document.body.removeChild(tempInput);
        }

        function downloadQR() {
            const qrImg = document.getElementById("qrImage");
            if (!qrImg || !qrImg.src) {
                alert("Không tìm thấy ảnh mã QR");
                return;
            }

            const link = document.createElement("a");
            link.href = qrImg.src;
            link.download = "qr-code.svg"; // Tên file khi tải xuống
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
@endsection


@section('customJs')

@endsection
