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
        <div class="w-full  min-h-full bg-white {{$loop->index == 6 ? '' : 'hidden'}}" id="part-{{$part->id}}">
            <div class="grid grid-cols-2 divide-x divide-x-gray-300 min-h-full" >
                <div class="p-5 min-h-full">
                    <h1 class="font-bold text-lg text-primary">{{$part->name}}</h1>
                    @if($part->content)
                        <div class="p-8">
                            {!! $part->content !!}
                        </div>
                    @endif
                </div>
                <div class="p-5 min-h-full">
                    @foreach($part->questionGroups as $questionGroup)
                        <div>
                            <h2 class="font-semibold text-lg text-primary" >{{$questionGroup->name}}</h2>
                            <div class="pl-5">
                                @if($questionGroup->answer_inside_content)
                                    @php
                                        $newContent =  preg_replace_callback('/\[(\d+)\]/', function ($matches) {
                                            $number = $matches[1];
                                            return '
                                                <button type="button" for="answers[' . $number . ']" class="btn btn-primary font-bold text-md w-6 h-6 rounded-full text-center">' . $number . '</button>
                                                <input type="text" name="answers[' . $number . ']"  class="form-control form-control-sm small w-32 ml-2"/>
                                            ';
                                        }, $questionGroup->content);
                                    @endphp
                                    <div class="text-md content-detail">
                                        {!! $newContent !!}
                                    </div>
                                @else
                                    @foreach($questionGroup->questions as $question)
                                        <div class="mt-2">
                                            <h3 class="font-semibold text-md">{{$question->name}}</h3>
                                            <div class="pl-5">
                                                {!! $question->content !!}
                                                <div class="grid grid-cols-1 gap-4 mt-4">
                                                    @foreach($question->answers as $answer)
                                                        <div class="answer-config-item border rounded p-3">
                                                            <div class="flex justify-start items-center rounded gap-4">
                                                                <input type="checkbox" class="form-checkbox h-4 w-4 text-primary" />
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
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
@endsection
