@extends('front.layouts.exam')
@section('title', $exam->name)

@section('head')
    <style>
        td, th{
            border: 1px solid gray;
            padding: 5px;
        }
        .content-detail {
            line-height: 3;
        }
    </style>
@endsection
@section('content')
    @foreach($exam->parts as $part)
        <div class="partContent flex-1 transition-all duration-300 ease-in-out {{ $loop->index == 0 ? '' : 'hidden' }} " id="part-{{$part->id}}">
            <div class="flex resizable-container" style="height: calc(100vh - 140px);">
                <!-- Left pane -->
                <div class="leftPane bg-green-50 w-1/2 min-w-[100px] max-w-[90%] overflow-auto p-10">
                    <h1 class="font-bold text-lg text-primary">{{ $part->name }}</h1>
                    @if($part->content)
                        <div class="p-8">
                            {!! $part->content !!}
                        </div>
                    @endif
                </div>

                <!-- Resizer -->
                <div class="resizer w-[6px] h-full cursor-col-resize bg-gray-200 hover:bg-gray-300 transition-all"></div>

                <!-- Right pane -->
                <div class="rightPane bg-white flex-1 overflow-auto p-10">
                    @foreach($part->questionGroups as $questionGroup)
                        <div>
                            <h2 class="font-semibold text-lg text-primary">{{ $questionGroup->name }}</h2>
                            <div class="pl-5">
                                @if($questionGroup->answer_inside_content)
                                    @php
                                        $newContent = preg_replace_callback('/\[(\d+)\]/', function ($matches) {
                                            $number = $matches[1];
                                            return '
                                                <div class="flex gap-2 items-center question-item">
                                                    <button type="button" for="answers[' . $number . ']" class="btn btn-primary font-bold text-md w-6 h-6 rounded-full text-center">' . $number . '</button>
                                                    <input type="text" name="answers[' . $number . ']" class="preview-input form-control form-control-sm small w-32 ml-2"/>
                                                </div>
                                            ';
                                        }, $questionGroup->content);
                                    @endphp
                                    <div class="text-md content-detail">
                                        {!! $newContent !!}
                                    </div>
                                @else
                                    @foreach($questionGroup->questions as $question)
                                        <div class="mt-2">
                                            <h3 class="font-semibold text-md">{{ $question->name }}</h3>
                                            <div class="pl-5">
                                                {!! $question->content !!}
                                                <div class="question-item grid grid-cols-1 gap-4 mt-4">
                                                    @foreach($question->answers as $answer)
                                                        <div class="answer-config-item border rounded p-3">
                                                            <div class="flex justify-start items-center rounded gap-4">
                                                                <input
                                                                    type="{{ $question->input_type == 'radio' ? 'radio' : 'checkbox' }}"
                                                                    name="answers[{{ $question->id }}]{{ $question->input_type == 'checkbox' ? '[]' : '' }}"
                                                                    value="{{ $answer->value }}"
                                                                    class="preview-input {{ $question->input_type == 'radio' ? 'form-radio' : 'form-checkbox' }} h-4 w-4 text-primary"
                                                                />
                                                                @if($answer->label)
                                                                    <p>{{ $answer->label }}</p>
                                                                @endif
                                                                <p>{{ $answer->value }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

{{--        <div class="{{ $part -> part_type == 'listening' ? '' : 'hidden' }}">--}}
{{--            {{$part -> name}}--}}
{{--        </div>--}}
    @endforeach
@endsection
