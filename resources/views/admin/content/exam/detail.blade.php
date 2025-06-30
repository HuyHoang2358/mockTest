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
                               {{-- <button type="button" class="absolute right-1.5 top-0.5 text-gray-500 cursor-pointer hover:text-red-500 text-sm"
                                        data-tw-target="#delete-object-confirm-form" data-tw-toggle="modal"
                                      onclick="openConfirmDeleteObjectForm('{{ $part->name}}', '{{ $part->id }}')">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>--}}
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
                    <div id="part-{{$part->id}}" class="tab-pane leading-relaxed p-5 {{$loop->index == 0 ? 'active' : ''}}" role="tabpanel" aria-labelledby="part-{{$part->id}}-tab">
                        <div class="flex justify-between items-center">
                            <!-- Danh sách file đính kèm -->
                            <div class="mt-2 flex justify-start items-center gap-2">
                                <button type="button" class="font-bold text-xl tooltip" data-theme="light" title="Đính kèm file">
                                    <i class="fa-solid fa-paperclip"></i>
                                </button>
                                @php
                                    $partAttachments = json_decode($part->attached_file);
                                    $files = $partAttachments;
                                    // remove path only keep file names
                                    if(is_array($partAttachments)){
                                        $partAttachments = array_map(function($item) {
                                            return basename($item);
                                        }, $partAttachments);
                                    } else {
                                        $partAttachments = [];
                                    }
                                @endphp
                                @if($partAttachments == '' ||  $files == null || count($files) == 0  )
                                    <span> Chưa có file đính kèm</span>
                                @else
                                    <span class="flex items">{{join(",",$partAttachments)}}</span>
                                    <audio controls>
                                        <source src="{{ asset($files[0]) }}" type="audio/mpeg">
                                    </audio>
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

                                <!-- Buttons: Edit Part -->
                                <a href="{{route('admin.part.edit', ['exam_id' => $exam->id, 'id' => $part->id])}}">
                                    <button type="button" class="btn btn-warning">
                                        <i class="fa-solid fa-pen-to-square mr-2"></i> Sửa
                                    </button>
                                </a>

                                <!-- Button: Delete Part -->
                                <button type="button" class="btn btn-danger"  data-tw-target="#delete-object-confirm-form" data-tw-toggle="modal"
                                        onclick="openConfirmDeleteObjectForm('{{ $part->name}}', '{{ $part->id }}')">
                                    <i class="fa-solid fa-trash mr-2"></i> Xóa
                                </button>

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
                                                }, $questionGroup->answer_content);
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


        </div>
    </div>
@endsection

@section('customJs')

@endsection
