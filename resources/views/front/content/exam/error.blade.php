@extends('front.layouts.frontApp')
@section('title', $exam->name )

@section('head')
    <style>
        td, th{
            border: 1px solid gray;
            padding: 5px;
        }
        .content-detail {
            line-height: 3;
        }
        .question-group-content-item p{
            text-indent: 20px;
            margin-top: 5px;
        }
    </style>
@endsection
@section('content')
    <div class="error-page flex flex-col lg:flex-row items-center justify-center text-center lg:text-left bg-[#1B253B] rounded-lg h-screen">
        <div class="-intro-x lg:mr-20">
            <img alt="MockTest not found" class="h-48 lg:h-auto" src="{{asset('assets/dist/images/error-illustration.svg')}}">
        </div>
        <div class="text-white mt-10 lg:mt-0">
            <div class="intro-x text-8xl font-medium">Lỗi 404</div>
            <div class="intro-x text-xl lg:text-3xl font-medium mt-5">Bài thi chưa được mở</div>
            <div class="intro-x text-lg mt-3">Vui lòng chờ cho đến khi giáo viên mở bài thi này!</div>
            <button class="intro-x btn py-3 px-4 text-white border-white dark:border-darkmode-400 dark:text-slate-200 mt-10">Quay lại trang chủ</button>
        </div>
    </div>
@endsection
