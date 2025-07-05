@extends('admin.layouts.adminApp')
@section('title', 'Thông tin đề thi')
@section('breadcrumb')
    <nav aria-label="breadcrumb" class="-intro-x h-[45px] mr-auto">
        <ol class="breadcrumb breadcrumb-light">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang Quản trị viên</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.folder.index').'?folder_id='.$exam->folder->id}}">{{$exam->folder->name}}</a></li>
            <li class="breadcrumb-item"><a  href="{{route('admin.exam.detail',$exam->id)}}">{{$exam->name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Thêm mới part</a></li>
        </ol>
    </nav>
@endsection
@section('head')
    <style>
        .question-item {
            scroll-margin-top: 20vh;
        }
        .question-group-item  {
            scroll-margin-top: 20vh;
        }
    </style>
@endsection
@section('content')
    <div class="grid grid-cols-12 gap-2 mt-4">
        <!-- Left side: Exam information -->
        <div class="col-span-9 border-l border-r border-b bg-white rounded-bl-lg rounded-br-lg p-5">
            <form action="{{route('admin.part.store', $exam->id)}}" method="POST">
                @csrf
                <!-- Tiêu đề -->
                <h1 class="my-2 text-xl font-semibold text-primary"> Đề thi: {{$exam->name}}</h1>
                <div class="flex justify-between items-center gap-4">
                    <!-- Tên phần thi -->
                    <div class="flex-grow">
                        <input type="text" placeholder="Nhập tên phần thi" class="font-semibold w-full text-2xl form-control py-1"
                               value="Part {{$part_number}}" name="part_name" readonly/>
                        <input id="part-attachment" class="form-control hidden" type="text" name="part_attachment">
                    </div>


                    <div class="flex justify-end items-center gap-3">
                        <!-- File đính kèm-->
                        <button type="button"  onclick="chooseFile(this,'part-attachment')"
                                class="font-bold text-xl tooltip choose-file relative" data-theme="light" title="Đính kèm file">
                            <i class="fa-solid fa-paperclip"></i>
                        </button>
                      {{--  <!-- Tổng số câu hỏi của phần -->
                        <div class="flex justify-start items-center gap-1">
                            <label for="part-1-number-question-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng số câu hỏi của phần">
                                <i class="fa-regular fa-circle-question"></i>
                            </label>
                            <input id="part-1-number-question-input" name="part_number_question" type="number" min=0 max= 100 class="w-16 form-control" readonly/>
                        </div>--}}

                      {{--  <!-- Tổng số điểm của phần -->
                        <div class="flex justify-start items-center gap-1">
                            <label for="part-1-total-score-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng điểm của phần (point)">
                                <i class="fa-regular fa-file-lines"></i>
                            </label>
                            <input id="part-1-total-score-input" name="part_total_score" type="number" min=0 max= 100 class="w-20 form-control" readonly/>
                        </div>--}}

                        <!-- Loại part -->
                        <div class="flex justify-start items-center gap-1">
                            <label for="part-type-select" class="font-bold text-xl tooltip" data-theme="light" title="Loại phần thi">
                                <i class="fa-solid fa-bars-staggered"></i>
                            </label>
                            <select id="part-type-select" name="part_type" class="form-select w-32" required>
                                <option value="reading">Reading</option>
                                <option value="listening">Listening</option>
                                <option value="writing">Writing</option>
                                <option value="speaking">Speaking</option>
                            </select>
                        </div>

                        <!-- Tổng thời gian làm bài của phần -->
                        <div class="flex justify-start items-center gap-1">
                            <label for="part-total-time-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng thời gian làm bài (phút)">
                                <i class="fa-regular fa-clock"></i>
                            </label>
                            <input id="part-total-time-input" name="part_time" type="number" min="0" max="720" class="w-20 form-control"/>
                        </div>
                    </div>
                </div>

                <!-- Mô tả các yêu cầu của phần thi -->
                <div class="flex items-center gap-4 mt-4 part-content">
                    <textarea type="text" class="form-control w-full text-sm" rows="2"
                              name="part_description" placeholder="Nhập các yêu cầu đề bài của phần thi"
                    ></textarea>
                </div>

                <!-- Nội dung phần thi -->
                <div class="flex items-center gap-4 mt-4 part-content">
                    <textarea type="text" class="form-control content-editor w-full text-sm" rows="3"
                              name="part_content" placeholder="Nhập nội dung phần thi, ví dụ như bài đọc, đoạn hội thoại, bài nghe, bài viết... "
                    ></textarea>
                </div>

                <!-- Nhóm câu hỏi -->
                <div class="part-content-detail">
                    <!-- Danh sách các nhóm câu hỏi -->
                    <div class="question-group">
                    </div>

                    <div class="flex justify-start items-center gap-2 mt-8">
                        <button class="btn btn-primary" type="button" onclick="addQuestionGroup()">
                            <i class="fa-solid fa-folder-plus mr-2"></i> Thêm nhóm câu hỏi
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end flex-col md:flex-row gap-2 mt-5">
                    <a href="{{route('admin.exam.detail', $exam->id)}}" >
                        <button type="button" class="btn py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 w-full md:w-52">Hủy</button>
                    </a>
                    <button type="submit" id="btn-submit-form" class="btn py-3 btn-primary w-full md:w-52">Lưu thông tin</button>
                </div>

            </form>
        </div>

        <!-- Summary Exam -->
        <div class="col-span-3 box">
            <div id="preview-part-exam" class="bg-white w-[19%] fixed">
                <h3 class="font-bold text-lg text-primary border-b border-gray-200 py-5 px-5"> Part {{$part_number}}</h3>
                <div class="p-2" id="preview-part-content">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom-modal')
    <!-- BEGIN: Modal Add Folder -->
    <div id="add-question-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">
                        Thêm mới câu hỏi
                    </h2>
                </div>
                <!-- END: Modal Header -->

                <!-- BEGIN: Modal Body -->
                <form id="add-question-form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-control mt-2">
                            <label for="part-1-total-score-input" class="form-label">
                                Loại câu hỏi
                            </label>
                            <select id="modal-question-type-id" class="form-select" name="question_type_id" onchange="handleQuestionTypeChange(this)">
                                @foreach($questionTypes as $questionType)
                                    <option value="{{$questionType->id}}">{{$questionType->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="config-question mt-2">
                            @foreach($questionTypes as $questionType)
                                <div class="modal-question-configs hidden" id="question-type-{{ $questionType->id }}">
                                    @foreach($questionType->configKeys as $config)
                                        <div class="mb-4 {{$config->key == 'input_type' ? 'hidden' : ''}}">
                                            <label class="form-label font-semibold">
                                                {{ $config->description ?? $config->key }}
                                            </label>
                                            @php
                                                $isSelectable = false;
                                                if ($config->value !== null) {
                                                    $values = json_decode($config->value, true);
                                                    $isSelectable = is_array($values) && count($values) > 0;
                                                }
                                            @endphp
                                            @if($isSelectable)
                                                <select name="{{ $config->key }}" class="form-select mt-1">
                                                    @foreach($values as $val)
                                                        <option value="{{ $val }}">{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="text"
                                                       name="{{ $config->key }}"
                                                       class="form-control mt-1"
                                                />
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Hủy</button>
                        <button type="button" class="btn btn-primary" onclick="addQuestion()">Thêm mới</button>
                    </div>
                </form>
                <!-- END: Modal Footer -->
            </div>
        </div>
    </div>
    <!-- END: Modal Add Folder -->
@endsection
@section('customJs')
    @include('admin.components.tinyInit')
    @include('admin.components.stand_alone_lfm_js')
    <script>
        let selectingQuestionType = ''; // Loại câu hỏi đang được chọn
        let questionCounter = 0; // Số lượng câu hỏi đã thêm
        let questionGroupIndex = 0; // Nhóm câu hỏi hiện tại, bắt đầu từ 1
        let selectingQuestionGroupId = null; // ID của nhóm câu hỏi đang được chọn để thêm câu hỏi

        function selectCurrentQuestionGroup(questionGroupId){
            selectingQuestionGroupId = questionGroupId;
        }

        function generateQuestionGroupHTML(questionGroupId) {
            return `
                  <div class="question-group-item mt-2 border-t-4 border-primary py-2" id="question-group-${questionGroupId}">
                        <!-- Title Question Group  -->
                        <div class="flex justify-between items-center gap-4">
                            <!-- Tên nhóm câu hỏi -->
                            <div class="flex-grow">
                                <input type="text" class="form-control text-md font-semibold text-primary" placeholder="Nhập tên nhóm câu hỏi"
                                       name="question_groups[${questionGroupId}][name]" required oninput="updateGroupNamePreview(this, '${questionGroupId}')">
                            </div>
                             <input id="question_groups-${questionGroupId}-attachment" class="form-control hidden" type="text" name="question_groups[${questionGroupId}][attachment]">
                            <!-- Files, Điểm, thời gian, câu hỏi -->
                            <div class="flex justify-end items-center gap-3">
                                <button type="button" class="font-bold text-xl tooltip relative"  onclick="chooseFile(this,'question_groups-${questionGroupId}-attachment')"
                                     data-theme="light" title="Đính kèm file">
                                    <i class="fa-solid fa-paperclip"></i>
                                </button>

                                <!-- Tổng số câu hỏi của nhóm câu hỏi -->
                                <div class="flex justify-start items-center gap-1">
                                    <label for="question-group-1-number-question-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng số câu hỏi của nhóm" >
                                        <i class="fa-regular fa-circle-question"></i>
                                    </label>
                                    <input id="question-group-1-number-question-input" name="question_groups[${questionGroupId}][number_of_questions]" type="number" min=0 max= 100 class="w-16 form-control" readonly/>
                                </div>

                                <!-- Tổng số điểm của nhóm câu hỏi -->
                                <div class="flex justify-start items-center gap-1">
                                    <label for="part-1-total-score-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng điểm của phần (point)">
                                        <i class="fa-regular fa-file-lines"></i>
                                    </label>
                                    <input id="part-1-total-score-input" name="question_groups[${questionGroupId}][score]" type="number" min=0 max= 100 class="w-20 form-control" readonly/>
                                </div>


                                <!-- Tổng thời gian làm bài của nhóm câu hỏi -->
                                <div class="flex justify-start items-center gap-1">
                                    <label for="part-1-total-score-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng thời gian làm bài (phút)">
                                        <i class="fa-regular fa-clock"></i>
                                    </label>
                                    <input id="part-1-total-score-input" name="question_groups[${questionGroupId}][time]" type="number" min=0 max= 100 class="w-20 form-control"/>
                                </div>

                                <!-- Delete Actions -->
                                <div class="flex justify-start items-center gap-1">
                                    <button type="button" class="text-xl tooltip text-red-300 hover:text-red-500"
                                            data-theme="light" title="Xóa nhóm câu hỏi"
                                            onclick="removeQuestionGroup('${questionGroupId}')"
                                    >
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Mô tả các yêu cầu của nhóm câu hỏi -->
                        <div class="flex items-center gap-4 mt-4 part-content">
                            <textarea type="text" class="form-control w-full text-sm" rows="2"
                                      name="question_groups[${questionGroupId}][description]" placeholder="Nhập các yêu cầu nhóm câu hỏi"
                            ></textarea>
                        </div>


                        <!-- Content Question Group -->
                        <div class="mt-2 pl-5 relative w-full">
                            <textarea type="text" class="form-control content-editor" placeholder="Nhập nội dung nhóm câu hỏi.  Đoạn văn, bài đọc, đoạn hội thoại, bài viết... "
                                      id="question-group-${questionGroupId}-content" name="question_groups[${questionGroupId}][content]"></textarea>
                        </div>

                        <!-- Checkbox để xác định câu trả lời nằm trong nội dung -->

                        <!-- Phiếu trả lời của nhóm câu hỏi-->
                        <div class="mt-2 pl-5 relative w-full">
                            <div class="mt-2 pl-5 w-full flex justify-start items-center gap-2">
                                <input type="checkbox" class="form-check-input"  onchange="toggleAnswerContent(this, ${questionGroupId})"
                                    id="question-group-${questionGroupId}-answer-inside-content" name="question_groups[${questionGroupId}][answer_inside_content]" />
                                <p class="italic"> Hiển thị phiếu trả lời dành cho cả nhóm câu hỏi</p>
                            </div>
                            <div  id="question-group-${questionGroupId}-answer-content" class="hidden mt-2">
                                <textarea type="text" class="form-control content-editor" placeholder="Nhập nội dung của phiếu trả lời. Vị trí các câu hỏi sẽ được đánh dấu bằng [1], [2], [3]..."
                                     id="question-group-${questionGroupId}-answer-content-input" name="question_groups[${questionGroupId}][answer_content]"></textarea>
                            </div>
                      </div>

                        <!-- Handle Question List -->
                        <div class="mt-2 pl-5">
                            <div class="flex justify-between items-center gap-4">
                                <h3 class="font-semibold text-primary text-md">Danh sách các câu hỏi</h3>
                                <div class="flex justify-end items-center gap-2">
                                    <!-- Thêm mới câu hỏi -->
                                    <button type="button" class="btn btn-primary tooltip"
                                            data-theme="light" title="Thêm câu hỏi"
                                            data-tw-toggle="modal" data-tw-target="#add-question-modal"
                                            onclick="selectCurrentQuestionGroup('${questionGroupId}')"
                                    >
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                    <!-- Trích danh sách câu hỏi từ content -->
                                    <button type="button" class="btn btn-primary tooltip hidden"
                                            id="btn-extract-questions-${questionGroupId}"
                                            data-theme="light" title="Thêm câu hỏi từ vị trí trong đề"
                                            onclick="handleExtractQuestions('${questionGroupId}')"
                                    >
                                        <i class="fa-solid fa-file-export"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mt-2 pl-5" id="question-list-${questionGroupId}">
                            </div>
                        </div>
                    </div>
            `
        }

        function initTinyMCE() {
            tinymce.init({
                selector: 'textarea.content-editor',
                plugins: 'anchor autolink  image link lists media searchreplace table wordcount preview',
                toolbar: 'undo redo | blocks | bold italic underline strikethrough | image table | align lineheight numlist bullist',
                menubar: false,
                height: 300, // chiều cao ban đầu ~2 dòng
                width: '100%',
                branding: false
            });
        }

        // TODO: Thêm nhóm câu hỏi
        function addQuestionGroup() {
            questionGroupIndex++;
            const container = document.querySelector('.question-group');
            const div = document.createElement('div');
            div.innerHTML =  generateQuestionGroupHTML(questionGroupIndex);
            container.appendChild(div.firstElementChild);
            initTinyMCE();
            // add to preview
            const previewContainer = document.getElementById('preview-part-content');
            const previewDiv =`
                <div class="rounded border border-gray-200 px-5 py-2 mt-2" id="preview-question-group-${questionGroupIndex}">
                    <a href="{{url('#question-group-')}}${questionGroupIndex}" >
                        <h4 class="py-2 font-semibold" id="preview-question-group-${questionGroupIndex}-name">Nhóm câu hỏi ${questionGroupIndex}</h4>
                    </a>
                    <div class="grid grid-cols-4 gap-2" id="preview-question-group-${questionGroupIndex}-questions">
                    </div>
                </div>`;
            previewContainer.insertAdjacentHTML('beforeend',previewDiv);
        }

        addQuestionGroup();

        function updateGroupNamePreview(input, questionGroupId) {
            const groupName = input.value.trim() || `Nhóm câu hỏi ${questionGroupId}`;
            const previewGroupName = document.getElementById(`preview-question-group-${questionGroupId}-name`);
            if (previewGroupName) previewGroupName.textContent = groupName;
        }

        function updateQuestionNamePreview(input, questionId) {
            const questionName = input.value.trim() || `Question ${questionId}`;
            // get num question from questionName in number end
            // Tìm số hoặc khoảng số ở cuối chuỗi, ví dụ: "1", "1-2", "10–12"
            const match = questionName.match(/\d+(?:\s*[-–]\s*\d+)?$/);

            const previewQuestionButton = document.getElementById(`preview-question-${questionId}`);
            if (previewQuestionButton) {
                previewQuestionButton.textContent = match ? match[0].replace(/\s+/g, '') : '';
            }
        }

        function removeQuestionGroup(questionGroupId) {
            const groupElement = document.getElementById(`question-group-${questionGroupId}`);
            if (groupElement) {
                groupElement.remove();
            }
            // Cập nhật lại preview
            const previewGroupElement = document.getElementById(`preview-question-group-${questionGroupId}`);
            if (previewGroupElement) {
                previewGroupElement.remove();
            }
        }

        function toggleQuestionVisibility(btn) {
            const questionBlock = btn.closest('.question-item').querySelector('[id^="question-item-"]');
            if (!questionBlock) return;

            const isHidden = questionBlock.classList.toggle('hidden');

            btn.innerHTML = isHidden
                ? '<i class="fa-regular fa-square"></i>'
                : '<i class="fa-regular fa-square-check"></i>';

        }

        function addQuestion() {
            const form = document.getElementById('add-question-form');
            const selectedTypeId = form.querySelector('[name="question_type_id"]').value;
            const configSection = document.querySelector(`#question-type-${selectedTypeId}`);

            const inputs = configSection.querySelectorAll('input, select');
            const configData = {};
            inputs.forEach(input => { configData[input.name] = input.value;});
            console.log('Config Data:', configData);

            const input_type =  configData['input_type'] || null;
            const answer_label = configData['label'] || 'A-Z';
            const num_answer = parseInt(configData['num_answer']) || 4; // Số đáp án mặc định là 4


            // them vị trí của câu hỏi vào content
            questionCounter++;
            const id = questionCounter;
            let html = `
                <div class="question-item border rounded p-3 my-3 flex justify-start items-start gap-2" id="question-${id}">
                    <!-- Nút toggle ẩn/hiện -->
                    <button type="button" onclick="toggleQuestionVisibility(this)" class="text-lg mt-1">
                        <i class="fa-regular fa-square-check"></i>
                    </button>

                    <!-- Nội dung câu hỏi -->
                    <div class="flex-grow">
                        <div class="flex justify-between items-center gap-4">
                            <input type="text" class="form-control w-48" name="question_groups[${selectingQuestionGroupId}][questions][${id}][label]" value="Question ${id}"  oninput="updateQuestionNamePreview(this, '${id}')"/>
                            <div class="flex items-center gap-4">
                                <!-- Loại câu hỏi -->
                                <div class="flex items-center gap-1">
                                    <i class="fa-solid fa-bars-staggered text-primary tooltip" data-theme="light" title="Loại câu hỏi"></i>
                                    <input type="text" class="form-control " name="question_groups[${selectingQuestionGroupId}][questions][${id}][question_type]" value="${selectingQuestionType}" readonly/>
                                    <input type="text" class="form-control hidden " name="question_groups[${selectingQuestionGroupId}][questions][${id}][question_type_id]" value="${selectedTypeId}" readonly/>
                                </div>

                                <div class="flex items-center gap-1">
                                    <i class="fa-solid fa-bars-staggered text-primary tooltip" data-theme="light" title="Loại câu hỏi"></i>
                                    <input type="text" class="form-control" name="question_groups[${selectingQuestionGroupId}][questions][${id}][input_type]" value="${input_type}" readonly />
                                </div>
                                <!-- Điểm -->
                                <div class="flex items-center gap-1">
                                    <i class="fa-regular fa-file-lines text-primary" title="Điểm"></i>
                                    <input type="number" name="question_groups[${selectingQuestionGroupId}][questions][${id}][score]" min="0" max="100" value="1" class="form-control w-16" />
                                </div>

                                <!-- Delete Actions -->
                                <div class="flex justify-start items-center gap-1">
                                    <button type="button" class="text-xl tooltip text-red-300 hover:text-red-500"
                                            data-theme="light" title="Xóa nhóm câu hỏi"
                                            onclick="removeQuestion('${id}')"
                                    >
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Nội dung bên trong câu hỏi -->
                        <div id="question-item-${id}" class="pl-4 mt-2">
                        </div>
                    </div>
                </div>`;

            const questionList = document.getElementById('question-list-'+selectingQuestionGroupId);
            questionList.insertAdjacentHTML('beforeend', html);

            /// Thêm cấu hình câu trả lời
            const configs = generateAnswerConfigs(input_type, answer_label, num_answer);
            render_answer_config(configs, 'question-item-'+id, id)

            // reset modal and close it
            form.reset(); // Reset form
            const modal = document.getElementById('add-question-modal');
            if (modal && typeof tailwind !== 'undefined' && tailwind.Modal) {
                const modalInstance = tailwind.Modal.getInstance(modal);
                modalInstance.hide(); // Ẩn modal nếu dùng tailwind modal JS
            } else {
                modal.classList.add('hidden'); // fallback thủ công
            }
            // Cập nhật preview
            const previewContainer = document.getElementById(`preview-question-group-${selectingQuestionGroupId}-questions`);
            const previewQuestionHtml = `<a href="{{url('#question-')}}${id}" ><button type="button" class="btn btn-secondary" id="preview-question-${id}">${id}</button> </a>`;
            previewContainer.insertAdjacentHTML('beforeend', previewQuestionHtml);
        }

        function removeQuestion(id) {
            const questionElement = document.getElementById(`question-${id}`);
            if (questionElement) questionElement.remove();
            // Cập nhật lại preview
            const previewQuestionElement = document.getElementById(`preview-question-${id}`);
            if (previewQuestionElement) previewQuestionElement.remove();


        }

        // TODO: Chuyển đổi số sang chữ La Mã
        function toRoman(num) {
            const romans = [
                ["M", 1000],
                ["CM", 900],
                ["D", 500],
                ["CD", 400],
                ["C", 100],
                ["XC", 90],
                ["L", 50],
                ["XL", 40],
                ["X", 10],
                ["IX", 9],
                ["V", 5],
                ["IV", 4],
                ["I", 1]
            ];

            let result = '';
            for (let [letter, value] of romans) {
                while (num >= value) {
                    result += letter;
                    num -= value;
                }
            }
            return result;
        }
        function create_options(labelType, numAnswer, inputType) {
            console.log("creating options", labelType, numAnswer, inputType);
            let configs = [];

            switch (labelType) {
                case 'A-Z':
                    for (let i = 0; i < numAnswer; i++) {
                        configs.push({
                            label: String.fromCharCode(65 + i), // A, B, C...
                            content: '',
                            is_correct: false,
                            input_type: inputType
                        });
                    }
                    break;

                case 'i-x':
                    for (let i = 0; i < numAnswer; i++) {
                        configs.push({
                            label: toRoman(i + 1),
                            content: '',
                            is_correct: false,
                            input_type: inputType
                        });
                    }
                    break;

                case 'T-F':
                    configs = [
                        { label: null, content: 'True', is_correct: false, input_type: 'radio' },
                        { label: null, content: 'False', is_correct: false, input_type: 'radio' }
                    ];
                    break;

                case 'T-F-N':
                    configs = [
                        { label: null, content: 'True', is_correct: false, input_type: 'radio' },
                        { label: null, content: 'False', is_correct: false, input_type: 'radio' },
                        { label: null, content: 'Not Given', is_correct: false, input_type: 'radio' }
                    ];
                    break;

                default:
                    for (let i = 0; i < numAnswer; i++) {
                        configs.push({
                            label: (i + 1).toString(),
                            content: '',
                            is_correct: false,
                            input_type: inputType
                        });
                    }
            }

            return configs;
        }

        function render_answer_config(configList, answerId, questionId) {
            const container = document.getElementById(answerId);
            let html = `
            <div class="flex justify-between items-center gap-4">
                <input type="text" class="form-control w-full" value=""  placeholder="Nhập nội dung câu hỏi"
                    name="question_groups[${selectingQuestionGroupId}][questions][${questionId}][content]" />
                <!--<button class="btn btn-secondary tooltip" type="button"
                        data-theme="light" title="Thêm  option cho đáp án"
                        onclick="addAnswerOption(this)">
                  <i class="fa-solid fa-plus"></i>
                </button>-->
            </div>
            `;
            configList.forEach((item, index) => {
                const input_type = item.input_type || 'text'; // Mặc định là text nếu không có input_type
                switch (input_type) {
                    case 'text':
                    case 'textarea':
                        html += `
                            <div class="answer-config-item border rounded p-3 my-2">
                                <div class="flex justify-start items-center rounded gap-4">
                                    <input type="checkbox" class="form-check-input" name="question_groups[${selectingQuestionGroupId}][questions][${questionId}][answer][${index}][is_correct]" checked readonly/>
                                    <input type="text" class="form-control w-12 font-semibold hidden" name="question_groups[${selectingQuestionGroupId}][questions][${questionId}][answer][${index}][label]" value="" readonly />

                                    <div class="flex-grow">
                                        <input type="text" class="form-control" name="question_groups[${selectingQuestionGroupId}][questions][${questionId}][answer][${index}][text]" placeholder="`+ `${input_type === 'select'? "Nhập đáp án cách nhau dấu ','" : "Nhập nội dung đáp án..." }`+`" />
                                    </div>
                                    <div class="flex justify-end items-center rounded gap-2">
                                        <button class="btn btn-secondary tooltip" type="button"
                                                data-theme="light" title="Thêm ghi chú cho đáp án"
                                                onclick="toggleAnswerNote(this)">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-danger-soft tooltip" type="button"
                                                data-theme="light" title="Xóa đáp án"
                                                onclick="deleteAnswerConfigItem(this)">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="answer-note hidden mt-2">
                                    <label class="form-label">Giải thích</label>
                                    <textarea name="question_groups[${selectingQuestionGroupId}][questions][${questionId}][answer][${index}][note]" class="form-control" rows="2" placeholder="Giải thích cho đáp án..."></textarea>
                                </div>
                            </div>`;
                        break;
                    case 'radio':
                    case 'checkbox':
                    case 'select':
                        html += `
                        <div class="answer-config-item border rounded p-3 my-2">
                            <div class="flex justify-start items-center rounded gap-4">
                                <input type="checkbox" class="form-check-input" name="question_groups[${selectingQuestionGroupId}][questions][${questionId}][answer][${index}][is_correct]" />

                                <input type="text" class="form-control w-12 font-semibold text-center ${item.label == null ? 'hidden' : ''}" name="question_groups[${selectingQuestionGroupId}][questions][${questionId}][answer][${index}][label]" value="${item.label == null ? '' : item.label}" readonly />

                                <div class="flex-grow">
                                    <input type="text" class="form-control" name="question_groups[${selectingQuestionGroupId}][questions][${questionId}][answer][${index}][text]"
                                           value="${item.content ?? ''}"
                                           ${item.label === null ? 'readonly' : ''}
                                           placeholder="Nhập nội dung đáp án..." />
                                </div>
                                <div class="flex justify-end items-center rounded gap-2">
                                    <button class="btn btn-secondary tooltip" type="button"
                                            data-theme="light" title="Thêm ghi chú cho đáp án"
                                            onclick="toggleAnswerNote(this)">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-danger-soft tooltip" type="button"
                                            data-theme="light" title="Xóa đáp án"
                                            onclick="deleteAnswerConfigItem(this)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="answer-note hidden mt-2">
                                <label class="form-label">Giải thích</label>
                                <textarea name="question_groups[${selectingQuestionGroupId}][questions][${questionId}][answer][${index}][note]" class="form-control" rows="2" placeholder="Giải thích cho đáp án..."></textarea>
                            </div>
                        </div>`;
                        break;
                    default:
                        break;
                }
            });
            container.innerHTML = html;
        }

        // TODO: ẩn hiện ghi chú đáp án
        function toggleAnswerNote(button) {
            const answerItem = button.closest('.answer-config-item');
            const noteSection = answerItem.querySelector('.answer-note');
            if (noteSection) {
                noteSection.classList.toggle('hidden');
            }
        }

        function generateAnswerConfigs(inputType, labelType = 'A-Z', numAnswer = 4) {
            // Xử lý trường hợp inputType là text hoặc textarea: chỉ 1 đáp án
            if (inputType === 'text' || inputType === 'textarea') {
                return [{
                    label: null,
                    content: '',
                    note: '',
                    is_correct: true,
                    input_type: inputType
                }];
            }
            // Nếu là radio/checkbox → cần tạo nhiều đáp án dựa vào labelType
            return create_options(labelType, numAnswer, inputType)
        }

        function handleQuestionTypeChange(select) {
            selectingQuestionType = select.options[select.selectedIndex].text;
            document.querySelectorAll('.modal-question-configs').forEach(el => el.classList.add('hidden'));
            document.getElementById(`question-type-${select.value}`)?.classList.remove('hidden');

        }

        document.addEventListener('DOMContentLoaded', () => {
            const select = document.querySelector('.form-select[onchange="handleQuestionTypeChange(this)"]');
            if (select) handleQuestionTypeChange(select);
        });


        // TODO: Phiếu trả lời
        function toggleAnswerContent(checkbox, questionGroupId) {
            const answerContent = document.getElementById(`question-group-${questionGroupId}-answer-content`);
            const btnExtract = document.getElementById(`btn-extract-questions-${questionGroupId}`);
            if (checkbox.checked) {
                answerContent.classList.remove('hidden');
                btnExtract.classList.remove('hidden')
            } else {
                answerContent.classList.add('hidden');
                btnExtract.classList.add('hidden')
            }
        }
        function handleExtractQuestions(questionGroupId) {
            //return;
            console.log('questionGroupId:', questionGroupId);
            const content = tinymce.get(`question-group-${questionGroupId}-answer-content-input`).getContent({ format: 'text' });


            // Regex tìm các số thứ tự bắt đầu dòng: 1. 2. 3. ...
            const questionRegex = /\[(\d+)\]\s*(.*?)(?=\[\d+\]|$)/gs;
            let match;
            const questions = [];
            selectingQuestionGroupId = questionGroupId; // Cập nhật nhóm câu hỏi hiện tại
            while ((match = questionRegex.exec(content)) !== null) {
                const label = parseInt(match[1]);      // Số thứ tự trong [1]
                const questionContent = match[2].trim(); // Nội dung câu hỏi
                questions.push({
                    label: label,
                    content: questionContent
                });
                // Thêm câu hỏi

                document.getElementById("modal-question-type-id").value = 4;
                addQuestion();
            }

            if (questions.length === 0) {
                alert('Không tìm thấy câu hỏi nào trong nội dung.');
                return;
            }

        }

        function deleteAnswerConfigItem(button){
            const answerItem = button.closest('.answer-config-item');
            if (answerItem) {
                answerItem.remove();
            }
        }
    </script>
@endsection
