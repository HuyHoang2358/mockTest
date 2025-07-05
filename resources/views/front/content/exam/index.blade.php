@extends('front.layouts.frontApp')
@section('title', $exam->name)

@section('head')

@endsection
@section('content')
    @if(isset($myAnswer) && $myAnswer )
        <h3 class="text-center">Your Answer</h3>
        @if ($myAnswer->status == 'CHECKING')
            <div class="alert alert-warning-soft">
                Bài làm của bạn đang được chấm. Vui lòng đợi và quay lại sau.
            </div>
        @elseif ($myAnswer->status == 'CHECKED')
            <div class="alert alert-success-soft">
                Đã chấm bài của bạn. Kết quả là: <strong>{{ $myAnswer->score }}</strong> điểm. <br>

            </div>
            <button class="btn btn-danger-soft mt-4">Xem kết quả chi tiết</button>
        @elseif ($myAnswer->status == 'DOING')
            TIẾP TỤC LÀM BÀI
        @endif
    @else
        Vào thi
    @endif
@endsection

@section('customJs')
@endsection
