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
                <div class="leftPane bg-green-50 w-1/2 min-w-[100px] max-w-[90%] overflow-auto p-10 ">
                    <h1 class="font-bold text-lg text-primary">{{ $part->name }}</h1>
                    @if($part->content)
                        <div class="p-8">
                            {!! $part->content !!}
                        </div>
                    @endif
                    <p class=" {{ $part->part_type == 'listening' ? '' : 'hidden' }}">xin chao</p>
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
    @endforeach


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
        playPauseBtn.addEventListener('click', () => {
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
        audio.addEventListener('play', () => {
            iconPlay.classList.add('hidden');
            iconPause.classList.remove('hidden');
        });
        audio.addEventListener('pause', () => {
            iconPause.classList.add('hidden');
            iconPlay.classList.remove('hidden');
        });

        // Tua nhanh / lùi
        forwardBtn.addEventListener('click', () => {
            audio.currentTime += 5;
        });

        backwardBtn.addEventListener('click', () => {
            audio.currentTime -= 5;
        });

        // Cập nhật progress bar & thời gian
        audio.addEventListener('timeupdate', () => {
            progressBar.value = audio.currentTime;
            updateTimeDisplay();
        });

        audio.addEventListener('loadedmetadata', () => {
            progressBar.max = audio.duration;
            updateTimeDisplay();
        });

        // Tua khi kéo progress bar
        progressBar.addEventListener('input', () => {
            audio.currentTime = progressBar.value;
        });

        // Âm lượng
        // Thiết lập âm lượng mặc định
        audio.volume = 1;
        audio.muted = false;

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
        volumeBar.addEventListener('input', () => {
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
        muteBtn.addEventListener('click', () => {
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
    </script>
@endsection
