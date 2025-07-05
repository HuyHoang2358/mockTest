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
        .question-group-content-item p{
            text-indent: 20px;
            margin-top: 5px;
        }
    </style>
@endsection
@section('content')
    @foreach($exam->parts as $part)
        <div class="partContent flex-1 transition-all duration-300 ease-in-out {{ $loop->index == 0 ? '' : 'hidden' }} " id="part-{{$part->id}}">
            @php
                $files = json_decode($part->attached_file, true) ?? [];
            @endphp
            @if($part->part_type == 'listening' && count($files) > 0)
                <!-- Nội dung của riêng Listening -->
                <div class="fixed flex items-center gap-4 px-8 py-3 bg-white shadow w-full">

                    <!-- Controls -->
                    <div class="flex items-center gap-4">
                        <audio id="audioPlayer" src="{{ asset($files[0]) }}"></audio>
                        <!-- Tua lùi 5s -->
                        <svg id="backwardBtn" class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="#6b7280"
                             stroke-width="1.5" stroke-linecap="butt" stroke-linejoin="round">
                            <path d="M2.5 2v6h6M2.66 15.57a10 10 0 1 0 .57-8.38"/>
                            <text x="12" y="16" text-anchor="middle" font-size="10"
                                  fill="#6b7280" stroke="#6b7280" stroke-width="0.75">5</text>
                        </svg>
                        <!-- Phát / Tạm dừng -->
                        <div id="playPauseBtn" class="bg-cyan-500 w-8 h-8 rounded-full flex justify-center items-center cursor-pointer pl-1">
                            <!-- Play Icon -->
                            <svg id="icon-play" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="#fff" stroke="#fff" stroke-width="2" stroke-linecap="butt" stroke-linejoin="round">
                                <polygon points="5 3 19 12 5 21 5 3"></polygon>
                            </svg>

                            <!-- Pause Icon -->
                            <svg id="icon-pause" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" viewBox="0 0 24 24" fill="#fff" stroke="#fff" stroke-width="2" stroke-linecap="butt" stroke-linejoin="round">
                                <rect x="3" y="4" width="4" height="16"></rect>
                                <rect x="12" y="4" width="4" height="16"></rect>
                            </svg><polygon points="5 3 19 12 5 21 5 3"></polygon>
                        </div>
                        <!-- Tua nhanh 5s -->
                        <svg id="forwardBtn" class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="#6b7280"
                             stroke-width="1.5" stroke-linecap="butt" stroke-linejoin="round">
                            <g transform="scale(-1,1) translate(-24,0)">
                                <path d="M2.5 2v6h6M2.66 15.57a10 10 0 1 0 .57-8.38"/>
                            </g>
                            <text x="12" y="16" text-anchor="middle" font-size="10"
                                  fill="#6b7280" stroke="#6b7280" stroke-width="0.75">5</text>
                        </svg>
                    </div>

                    <!-- Time -->
                    <span id="timeDisplay" class="text-sm text-gray-600"></span>

                    <!-- Progress bar -->
                    <input type="range" id="progressBar" class="w-full h-[6px] accent-cyan-400 bg-gray-500 rounded" min="0" value="0" step="0.1" />

                    <!-- Volume -->
                    <div class="flex items-center gap-2">
                        <!-- Nút bật/tắt âm -->
                        <div id="muteBtn" class="cursor-pointer">
                            <!-- Loa to (hiển thị mặc định) -->
                            <svg id="icon-volume" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M11 5L6 9H2v6h4l5 4V5z" />
                                <path d="M15.54 8.46a5 5 0 010 7.07M19.07 4.93a10 10 0 010 14.14" />
                            </svg>

                            <!-- Loa tắt (ẩn ban đầu) -->
                            <svg id="icon-muted" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-500 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M11 5L6 9H2v6h4l5 4V5z" />
                                <line x1="18" y1="6" x2="6" y2="18" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </div>

                        <!-- Thanh volume -->
                        <input id="volumeBar" type="range" class="w-24 h-2 accent-cyan-400 bg-cyan-100 rounded" min="0" max="1" step="0.01" value="1" />
                    </div>
                </div>
            @endif


            <!-- Nội dung phần Exam -->
            <div class="flex resizable-container {{ $part->part_type == 'listening' ? 'pt-12' : '' }}" style="height: calc(100vh - 140px)">
            <!-- Left pane -->
            <div class="leftPane bg-green-50 w-1/2 min-w-[100px] max-w-[90%] overflow-auto p-4">
                <!-- Part title and description -->
                <div class="bg-[#f1f2ec] p-4">
                    <h1 class="font-bold text-lg text-primary">{{ $part->name }}</h1>
                    @if($part->description)
                        <div class="">
                            {!! $part->description !!}
                        </div>
                    @endif
                </div>
                @if($part->content)
                    <div class="question-group-content-item font-normal text-base p-4" id="part-content-{{ $part->id }}">
                        {!! $part->content !!}
                    </div>
                @endif
                @foreach($part->questionGroups as $questionGroup)
                    <div class="question-group-content-item font-normal text-base p-4" id="question-group-content-{{ $questionGroup->id }}">
                        {!! $questionGroup->content !!}
                    </div>
                @endforeach
            </div>

            <!-- Resizer -->
            <div class="resizer w-[6px] h-full cursor-col-resize bg-gray-200 hover:bg-gray-300 transition-all"></div>

            <!-- Right pane -->
            <div class="rightPane bg-white flex-1 overflow-auto p-4">
                @foreach($part->questionGroups as $questionGroup)
                    <div class="question-group-item mt-2" id="question-group-{{ $questionGroup->id }}">
                        <h2 class="font-semibold text-base text-primary">{{ $questionGroup->name }}</h2>
                        @if($questionGroup->description)
                            <div class="text-sm text-gray-600 mt-1">
                                {!! $questionGroup->description !!}
                            </div>
                        @endif
                        <div class="pl-4">
                            @if($questionGroup->answer_inside_content)
                                @php
                                    $question = $questionGroup->questions;
                                    // create map key is number in content, value is question id

                                    $questionMap = [];
                                    foreach ($question as $q) $questionMap[$q->number] = $q->id;


                                    $newContent = preg_replace_callback('/\[(\d+)\]/', function ($matches) use ($questionMap) {
                                        $number = $matches[1];
                                        return '
                                            <span class="question-item ml-2 mr-2"  data-question="'.$questionMap[$number].'">
                                                <button type="button" for="answers[' . $number . ']" class="btn btn-primary font-bold text-md w-6 h-6 rounded-full text-center">' . $number . '</button>
                                                <input type="text" name="answers[' . $number . ']" class="inline-block preview-input form-control form-control-sm w-32 ml-1" data-index="'.$questionMap[$number] .'"/>
                                            </span>
                                        ';
                                    }, $questionGroup->answer_content);
                                @endphp
                                <div class="text-md content-detail">
                                    {!! $newContent !!}
                                </div>
                            @else
                                @foreach($questionGroup->questions as $question)
                                    <div class="mt-4 text-sm">
                                        <p><span class="font-semibold test-sm">{{ $question->name }}:</span> {!! $question->content !!}</p>
                                        <div class="pl-4">
                                            <div class="question-item grid grid-cols-1 gap-1 mt-2" data-question="{{$question->id}}">
                                                @if($question->input_type == 'select')
                                                    <div class="answer-config-item border rounded p-3 hover:bg-green-200">
                                                        <div class="flex justify-start items-center rounded gap-4">
                                                            <select name="answers[{{ $question->id }}]" class="preview-input form-select form-select-sm text-sm" data-index="{{$question->id}}">
                                                                <option value="">-- Chọn đáp án --</option>
                                                                @foreach($question->answers as $answer)
                                                                    <option value="{{ $answer->id }}">{{ ($answer->label ?? '') .'. '. ($answer->value ?? '') }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @elseif ($question->input_type == 'textarea')
                                                    <div class="answer-config-item mt-4">
                                                        <textarea name="answers[{{ $question->id }}]" class="answer-textarea preview-input form-control form-control-sm w-full text-base"
                                                                  rows="16" data-index="{{$question->id}}"
                                                        ></textarea>
                                                        <div class="word-count font-normal text-right text-sm text-gray-400 mt-2 ml-2">0 từ</div>
                                                    </div>
                                                @elseif ($question->input_type == 'text')
                                                    <div class="answer-config-item mt-2">
                                                        <input  type="text" name="answers[{{ $question->id }}]" class="preview-input form-control form-control-sm w-full text-base"
                                                               data-index="{{$question->id}}" placeholder="Nhập đáp án vào chỗ trống"/>
                                                    </div>
                                                @else
                                                    @foreach($question->answers as $answer)
                                                        <div class="answer-config-item border rounded p-3 hover:bg-green-200">
                                                            <label class="flex items-center gap-2 cursor-pointer">
                                                                <div class="flex justify-start items-center rounded gap-4">
                                                                    <input
                                                                        type="{{ $question->input_type == 'radio' ? 'radio' : 'checkbox' }}"
                                                                        name="answers[{{ $question->id }}]{{ $question->input_type == 'checkbox' ? '[]' : '' }}"
                                                                        value="{{ $answer->value }}"
                                                                        class="preview-input {{ $question->input_type == 'radio' ? 'form-radio' : 'form-checkbox' }}
                                                                        h-4 w-4 text-primary form-control"
                                                                        data-index="{{$question->id}}"
                                                                    />
                                                                    @if($answer->label)
                                                                        <span>{{ $answer->label }}</span>
                                                                    @endif
                                                                    <span>{{ $answer->value }}</span>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @endif
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

@section('customJs')
    <script>
        const playPauseBtn = document.getElementById('playPauseBtn');
        const forwardBtn = document.getElementById('forwardBtn');
        const backwardBtn = document.getElementById('backwardBtn');
        const progressBar = document.getElementById('progressBar');
        const timeDisplay = document.getElementById('timeDisplay');
        const audio = document.getElementById('audioPlayer');
        const volumeBar = document.getElementById('volumeBar');
        const muteBtn = document.getElementById('muteBtn');
        const iconVolume = document.getElementById('icon-volume');
        const iconMuted = document.getElementById('icon-muted');
        const iconPlay = document.getElementById('icon-play');
        const iconPause = document.getElementById('icon-pause');

        // Phát / Tạm dừng
        playPauseBtn?.addEventListener('click', () => {
            if (audio.paused) {
                audio.play();
                iconPlay.classList.add('hidden');
                iconPause.classList.remove('hidden');
            } else {
                audio.pause();
                iconPause.classList.add('hidden');
                iconPlay.classList.remove('hidden');
            }
        });
        // Đồng bộ icon khi audio tự chạy hoặc dừng
        audio?.addEventListener('play', () => {
            iconPlay.classList.add('hidden');
            iconPause.classList.remove('hidden');
        });
        audio?.addEventListener('pause', () => {
            iconPause.classList.add('hidden');
            iconPlay.classList.remove('hidden');
        });

        // Tua nhanh / lùi
        forwardBtn?.addEventListener('click', () => {
            audio.currentTime += 5;
        });

        backwardBtn?.addEventListener('click', () => {
            audio.currentTime -= 5;
        });

        // Cập nhật progress bar & thời gian
        audio?.addEventListener('timeupdate', () => {
            progressBar.value = audio.currentTime;
            updateTimeDisplay();
        });

        audio?.addEventListener('loadedmetadata', () => {
            progressBar.max = audio.duration;
            updateTimeDisplay();
        });

        // Tua khi kéo progress bar
        progressBar?.addEventListener('input', () => {
            audio.currentTime = progressBar.value;
        });

        // Âm lượng
        // Thiết lập âm lượng mặc định
        if (audio) audio.volume = 1;
        if (audio)  audio.muted = false;

        // Cập nhật icon dựa trên trạng thái mute
        function updateVolumeIcon() {
            if (audio.muted || audio.volume === 0) {
                iconMuted.classList.remove('hidden');
                iconVolume.classList.add('hidden');
            } else {
                iconMuted.classList.add('hidden');
                iconVolume.classList.remove('hidden');
            }
        }

        // Bắt sự kiện thay đổi volume
        volumeBar?.addEventListener('input', () => {
            const volume = parseFloat(volumeBar.value);
            audio.volume = volume;

            // Đồng bộ trạng thái muted
            if (volume === 0) {
                audio.muted = true;
            } else {
                audio.muted = false;
            }
            updateVolumeIcon();
        });

        // Bắt sự kiện click vào icon mute
        muteBtn?.addEventListener('click', () => {
            audio.muted = !audio.muted;

            // Nếu mute thì giữ nguyên volumeBar, nếu unmute thì khôi phục volume trước đó hoặc ít nhất là 0.1
            if (!audio.muted && audio.volume === 0) {
                audio.volume = 0.5;
                volumeBar.value = 0.5;
            }
            updateVolumeIcon();
        });


        // Hiển thị thời gian
        function updateTimeDisplay() {
            const format = t => {
                const m = Math.floor(t / 60);
                const s = Math.floor(t % 60).toString().padStart(2, '0');
                return `${m}:${s}`;
            };
            const remaining = (audio.duration || 0) - audio.currentTime;
            timeDisplay.textContent = `-${format(remaining)}`;
        }

        // TODO: Count words
        function countWords(text) {
            return text.trim().split(/\s+/).filter(word => word.length > 0).length;
        }

        document.querySelectorAll('.answer-textarea').forEach(textarea => {
            const wordCountDiv = textarea.parentElement.querySelector('.word-count');

            textarea.addEventListener('input', function () {
                const wordCount = countWords(this.value);
                wordCountDiv.textContent = `${wordCount} từ`;
            });
        });
    </script>
@endsection
