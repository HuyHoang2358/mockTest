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
@section('content')
    <div class="grid grid-cols-12 gap-6 mt-4">
        <div class="col-span-9">
            <div class="flex justify-between items-center">
                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li id="part-1-tab" class="nav-item relative flex items-center " role="presentation">
                            <button class="nav-link w-full py-3 pr-8 text-left active" type="button" role="tab"
                                    data-tw-toggle="pill" data-tw-target="#part-1"
                                    aria-controls="part-1" aria-selected="true"
                            >
                                Part 1
                            </button>
                            <span class="absolute right-1.5 top-0.5 text-gray-500 cursor-pointer hover:text-red-500 text-sm"
                                  onclick="removePart('part-1')">
                                <i class="fa-solid fa-xmark"></i>
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="">
                    <button id="add-part-btn" class="btn btn-primary">
                        <i class="fa-solid fa-plus mr-2"></i> Part
                    </button>
                </div>
            </div>

            <div class="tab-content border-l border-r border-b bg-white rounded-bl-lg rounded-br-lg">
                <div id="part-1" class="tab-pane leading-relaxed p-5 active" role="tabpanel" aria-labelledby="part-1-tab">
                    <div class="flex justify-between items-center">
                        <!-- Danh sách file đính kèm -->
                        <div class="mt-2 flex justify-start items-center gap-2">
                            <button type="button" class="font-bold text-xl tooltip" data-theme="light" title="Đính kèm file">
                                <i class="fa-solid fa-paperclip"></i>
                            </button>
                            <span> Chưa có file đính kèm</span>
                        </div>

                        <!-- Điểm, thời gian, câu hỏi -->
                        <div class="flex justify-end items-center gap-3">
                            <!-- Tổng số câu hỏi của phần -->
                            <div class="flex justify-start items-center gap-1">
                                <label for="part-1-total-score-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng số câu hỏi của phần">
                                    <i class="fa-regular fa-circle-question"></i>
                                </label>
                                <input id="part-1-total-score-input" name="total_score" type="number" min=0 max= 100 class="w-16 form-control"/>
                            </div>

                            <!-- Tổng số điểm của phần -->
                            <div class="flex justify-start items-center gap-1">
                                <label for="part-1-total-score-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng điểm của phần (point)">
                                    <i class="fa-regular fa-file-lines"></i>
                                </label>
                                <input id="part-1-total-score-input" name="total_score" type="number" min=0 max= 100 class="w-20 form-control"/>
                            </div>


                            <!-- Tổng thời gian làm bài của phần -->
                            <div class="flex justify-start items-center gap-1">
                                <label for="part-1-total-score-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng thời gian làm bài (phút)">
                                    <i class="fa-regular fa-clock"></i>
                                </label>
                                <input id="part-1-total-score-input" name="total_score" type="number" min=0 max= 100 class="w-20 form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 mt-4 part-content">
                        <input type="text" value="Nội dung part 1"
                               class="flex-grow font-semibold border-none w-full text-2xl part-content-input py-1"
                               readonly
                        />
                        <!-- edit button -->
                        <button class="btn btn-secondary" type="button" onclick="toggleEdit(this)">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </div>


                   {{-- <div class="flex justify-start items-center gap-2">
                        <button class="btn btn-primary" type="button" data-tw-toggle="modal"
                                data-tw-target="#add-folder-modal">
                            <i class="fa-solid fa-folder-plus mr-2"></i> Thêm folder
                        </button>
                    </div>
                    <div class="flex justify-end items-center gap-2">
                        <button class="btn btn-primary" type="button">
                            <i class="fa-solid fa-plus mr-2"></i> Câu hỏi
                        </button>
                    </div>--}}

                    <div class="part-content-detail mt-2 border-t border-gray-300 py-2">
                        <!-- Danh sách các nhóm câu hỏi -->
                        <div class="question-group">
                            <div class="question-group-1">
                                <!-- Title Question Group  -->
                                <div class="flex justify-between items-center gap-4">
                                    <!-- Danh sách file đính kèm -->
                                    <div class="flex-grow">
                                        <input type="text" class="form-control" placeholder="Nhập tên nhóm câu hỏi" name="question_type_name" required>
                                    </div>

                                    <!-- Điểm, thời gian, câu hỏi -->
                                    <div class="flex justify-end items-center gap-3">
                                        <button type="button" class="font-bold text-xl tooltip" data-theme="light" title="Đính kèm file">
                                            <i class="fa-solid fa-paperclip"></i>
                                        </button>

                                        <!-- Tổng số câu hỏi của phần -->
                                        <div class="flex justify-start items-center gap-1">
                                            <label for="part-1-total-score-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng số câu hỏi của phần">
                                                <i class="fa-regular fa-circle-question"></i>
                                            </label>
                                            <input id="part-1-total-score-input" name="total_score" type="number" min=0 max= 100 class="w-16 form-control"/>
                                        </div>

                                        <!-- Tổng số điểm của phần -->
                                        <div class="flex justify-start items-center gap-1">
                                            <label for="part-1-total-score-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng điểm của phần (point)">
                                                <i class="fa-regular fa-file-lines"></i>
                                            </label>
                                            <input id="part-1-total-score-input" name="total_score" type="number" min=0 max= 100 class="w-20 form-control"/>
                                        </div>


                                        <!-- Tổng thời gian làm bài của phần -->
                                        <div class="flex justify-start items-center gap-1">
                                            <label for="part-1-total-score-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng thời gian làm bài (phút)">
                                                <i class="fa-regular fa-clock"></i>
                                            </label>
                                            <input id="part-1-total-score-input" name="total_score" type="number" min=0 max= 100 class="w-20 form-control"/>
                                        </div>
                                    </div>
                                </div>

                                <!-- Content Question Group -->
                                <div class="mt-2">
                                    <textarea type="text" class="form-control content-editor" placeholder="Nội dung nhóm câu hỏi" name="question_type_description">
                                        {!! '<p>[1]</p> <p>[2]</p>  <p>[3]</p>' !!}
                                    </textarea>
                                </div>

                                <!-- Handle Question List -->
                                <div class="mt-2">
                                    <!-- checkbox câu hỏi nằm trong content -->
                                    <div class="flex justify-start items-center gap-2">
                                        <input type="checkbox" class="form-check-input" onclick="handleExtractQuestions(this)" />
                                        <label>Vị trí câu hỏi nằm trong content</label>
                                        <span class="tooltip text-yellow-500" type="button"
                                                data-theme="light" title="Vị trí câu hỏi nằm trong dấu '[ ]'. Ví du: [1], [2]"
                                        >
                                            <i class="fa-solid fa-circle-info"></i>
                                        </span>
                                    </div>

                                    <h3 class="font-semibold text-primary text-xl">Danh sách các câu hỏi</h3>

                                    <div class="question-list mt-2 pl-5">
                                        <div class="question-item flex justify-between items-center gap-4">
                                            <p>Câu hỏi 1:</p>
                                            <div class="question-item flex justify-end items-center gap-4">
                                                <!-- Loại câu hỏi -->
                                                <div class="flex justify-start items-center gap-1">
                                                    <label for="part-1-total-score-input" class="font-bold text-xl tooltip" data-theme="light" title="Loại câu hỏi">
                                                        <i class="fa-solid fa-bars-staggered"></i>
                                                    </label>
                                                    <select class="form-select" onchange="handleQuestionTypeChange(this)">
                                                        @foreach($questionTypes as $questionType)
                                                            <option value="{{$questionType->id}}"
                                                                    data-config='@json($questionType->configKeys)'
                                                            >{{$questionType->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Cấu hình câu hỏi -->
                                                <div class="flex justify-start items-center gap-1">
                                                    <div class="text-center">
                                                        <div class="dropdown inline-block" data-tw-placement="bottom-end">
                                                            <button type="button" class="dropdown-toggle btn btn-secondary tooltip text-lg"
                                                                    aria-expanded="false" data-tw-toggle="dropdown"
                                                                    title="Cấu hình câu hỏi"
                                                            >
                                                                <i class="fa-solid fa-screwdriver-wrench"></i>
                                                            </button>
                                                            <div class="dropdown-menu w-80">
                                                                <div class="dropdown-content">
                                                                    <div id="question-config-container">
                                                                        <div class="mb-4">
                                                                            <h5 class="font-semibold text-lg text-primary">Cấu hình câu hỏi</h5>
                                                                            @foreach($questionTypes[0]->configKeys as $configKey)
                                                                                <div class="form-control mt-2">
                                                                                    <label class="form-label">{{$configKey->description}}</label>
                                                                                    @if($configKey->value)
                                                                                        <select name="config[is_shuffle]" class="form-select mt-1">
                                                                                            @php
                                                                                                $configKeyValues = json_decode($configKey->value, true);
                                                                                            @endphp
                                                                                            @foreach($configKeyValues as $configKeyValue)
                                                                                                <option value="{{$configKeyValue}}">{{$configKeyValue}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    @else
                                                                                        <input type="text" class="form-control" />
                                                                                    @endif
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="flex items-center mt-3">
                                                                            <button data-dismiss="dropdown" class="btn btn-secondary ml-auto">Đóng</button>
                                                                            <button class="btn btn-primary ml-2" onclick="applyConfig()">Lưu</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- Số điểm của câu hỏi -->
                                                <div class="flex justify-start items-center gap-1">
                                                    <label for="part-1-total-score-input" class="font-bold text-xl tooltip" data-theme="light" title="Điểm của câu hỏi">
                                                        <i class="fa-regular fa-file-lines"></i>
                                                    </label>
                                                    <input id="part-1-total-score-input" name="total_score" type="number" min=0 max= 100 class="w-16 form-control" value="1"/>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Đáp án trả lời -->
                                        <div class="p-5">
                                            @php
                                                $answerLabels = ['A', 'B', 'C', 'D'];
                                            @endphp
                                            @for($i=0; $i<4; $i++)
                                                <div class="flex justify-between items-center gap-4 my-1">
                                                    <label for="answer-{{$i}}" class="font-semibold text-xl">{{$answerLabels[$i]}}</label>
                                                    <input id="answer-{{$i}}" type="text" class="form-control" placeholder="Nhập đáp án" name="answers[]">
                                                    <input type="radio" class="form-check-input" name="is_correct[]" value="{{$i}}"  {{$i==3 ? 'checked' : ''}}/>
                                                </div>
                                            @endfor



                                            <div> --- </div>
                                            @php
                                                $answerLabels = ['True', 'False'];
                                            @endphp
                                            @for($i=0; $i<1; $i++)
                                                <div class="flex justify-left  items-center gap-4 my-1">
                                                    <label for="answer-{{$i}}" class="font-semibold text-xl">{{$i+1}}</label>
                                                    <div class="flex justify-start items-center gap-8 my-1">
                                                        @foreach($answerLabels as $label)
                                                            <div class="flex justify-start items-center gap-2">
                                                                <input type="radio" class="form-check-input" name="is_correct_{{$i}}_[]" value="{{$i}}"  {{$i==1 || $i==2 || $i==3 ? 'checked' : ''}}/>
                                                                <div>
                                                                    {{$label}}
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endfor

                                            <div> --- </div>
                                            @php
                                                $answerLabels = ['True', 'False', 'Not Given'];
                                            @endphp
                                            @for($i=0; $i<1; $i++)
                                                <div class="flex justify-left items-center gap-4 my-1">
                                                    <label for="answer-{{$i}}" class="font-semibold text-xl">{{$i+1}}</label>
                                                    <div class="flex justify-start items-center gap-8 my-1">
                                                        @foreach($answerLabels as $label)
                                                            <div class="flex justify-start items-center gap-2">
                                                                <input type="radio" class="form-check-input" name="is_correct_{{$i}}_[]" value="{{$i}}"  {{$i==1 || $i==2 || $i==3 ? 'checked' : ''}}/>
                                                                <div>
                                                                    {{$label}}
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endfor


                                            <div> --- </div>
                                            @for($i=0; $i<6; $i++)
                                                <div class="flex justify-between items-center gap-4 my-1">
                                                    <label for="answer-{{$i}}" class="font-semibold text-xl">{{$i+1}}</label>
                                                    <input id="answer-{{$i}}" type="text" class="form-control" placeholder="Nhập đáp án" name="answers[]">
                                                    <input type="checkbox" class="form-check-input" name="is_correct[]" value="{{$i}}"  {{$i==1 || $i==2 || $i==3 ? 'checked' : ''}}/>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-start items-center gap-2 mt-8">
                            <button class="btn btn-primary" type="button" data-tw-toggle="modal"
                                    data-tw-target="#add-folder-modal">
                                <i class="fa-solid fa-folder-plus mr-2"></i> Thêm nhóm câu hỏi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-3 box p-5">
            <div id="summary-exam" class="accordion accordion-boxed">
                <div class="accordion-item">
                    <div id="summary-exam-part-1-label" class="accordion-header">
                        <button class="accordion-button font-bold" type="button"
                                data-tw-toggle="collapse" data-tw-target="#summary-exam-part-1-collapse"
                                aria-expanded="true" aria-controls="summary-exam-part-1-collapse"
                        >
                            Part 1
                        </button>
                    </div>
                    <div id="summary-exam-part-1-collapse" class="accordion-collapse"
                         aria-labelledby="summary-exam-part-1-label" data-tw-parent="#summary-exam"
                    >
                        <div class="accordion-body text-slate-600 dark:text-slate-500 leading-relaxed">
                            <button class="btn btn-primary question-item"> 1</button>
                            <button class="btn btn-primary">2</button>
                            <button class="btn btn-primary">3</button>
                            <button class="btn btn-primary">4</button>
                            <button class="btn btn-primary">5</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom-modal')
    <!-- BEGIN: Modal Add Folder -->
    <div id="add-folder-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">
                        Thêm mới folder
                    </h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <form action="{{route('admin.folder.store')}}" method="POST">
                    @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-parent-folder-name" class="form-label">Thư mục cha</label>
                            <input id="modal-parent-folder-name" type="text" class="form-control" name="parent_name" readonly>
                        </div>

                        <div class="col-span-12 sm:col-span-12 hidden">
                            <label for="modal-parent-folder-id" class="form-label">ID thư mục cha</label>
                            <input id="modal-parent-folder-id" type="text" class="form-control" name="parent_id" readonly>
                        </div>

                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-2" class="form-label">Tên thư mục thêm mới</label>
                            <input id="modal-form-2" type="text" name="name" class="form-control" placeholder="Nhập tên thư mục mới" required>
                        </div>
                    </div>
                    <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Hủy</button>
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
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
    <script>
        // === Handle Part ===
        let partCount = 1; // Bắt đầu từ 2 vì đã có Part 1 và Part 2
        // TODO: Thêm phần mới
        document.getElementById('add-part-btn').addEventListener('click', function () {
            partCount++;
            const partName = 'Part ' + partCount;
            const partId = 'part-' + partCount;

            addTabHeader(partId, partName);
            addTabContent(partId, partName);
            addSummaryAccordion(partId, partName);

            // === Kích hoạt part vừa thêm ===
            document.querySelectorAll('.nav-link').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));

            const newTab = document.querySelector(`#${partId}-tab .nav-link`);
            const newPane = document.getElementById(partId);

            if (newTab) newTab.classList.add('active');
            if (newPane) newPane.classList.add('active');
        });

        function addTabHeader(partId, partName) {
            const newTab = document.createElement('li');
            newTab.className = 'nav-item relative flex items-center';
            newTab.setAttribute('role', 'presentation');
            newTab.id = `${partId}-tab`;

            newTab.innerHTML = `
                <button class="nav-link w-full py-3 pr-8 text-left" type="button" role="tab"
                        data-tw-toggle="pill" data-tw-target="#${partId}"
                        aria-controls="${partId}" aria-selected="false">
                    ${partName}
                </button>
                 <span class="absolute right-1.5 top-0.5 text-gray-500 cursor-pointer hover:text-red-500 text-sm"
                      onclick="removePart('${partId}')">
                    <i class="fa-solid fa-xmark"></i>
                </span>
            `;

            document.querySelector('.nav-tabs').appendChild(newTab);
        }

        function addTabContent(partId, partName) {
            const newTabContent = document.createElement('div');
            newTabContent.className = 'tab-pane leading-relaxed p-5';
            newTabContent.id = partId;
            newTabContent.setAttribute('role', 'tabpanel');
            newTabContent.setAttribute('aria-labelledby', `part-${partId}-tab`);

            newTabContent.innerHTML = `Nội dung cho ${partName}`;

            document.querySelector('.tab-content').appendChild(newTabContent);
        }

        function addSummaryAccordion(partId, partName) {
            const summaryAccordion = document.createElement('div');
            summaryAccordion.className = 'accordion-item';
            summaryAccordion.innerHTML = `
            <div id="summary-exam-${partId}-label" class="accordion-header">
                <button class="accordion-button font-bold" type="button"
                        data-tw-toggle="collapse" data-tw-target="#summary-exam-${partId}-collapse"
                        aria-expanded="false" aria-controls="summary-exam-${partId}-collapse">
                    ${partName}
                </button>
            </div>
            <div id="summary-exam-${partId}-collapse" class="accordion-collapse"
                 aria-labelledby="summary-exam-${partId}-label" data-tw-parent="#summary-exam">
                <div class="accordion-body text-slate-600 dark:text-slate-500 leading-relaxed">
                    ${generateQuestionButtons()}
                </div>
            </div>
        `;

            document.getElementById('summary-exam').appendChild(summaryAccordion);
        }

        function generateQuestionButtons(count = 5) {
            let buttons = '';
            for (let i = 1; i <= count; i++) {
                buttons += `<button class="btn btn-primary question-item">${i}</button> `;
            }
            return buttons;
        }

        // TODO: Xoá phần đã chọn
        function removePart(partId) {
            // Xóa tab header
            const tabItem = document.getElementById(`${partId}-tab`);
            const wasActive = tabItem?.querySelector('button')?.classList.contains('active');
            if (tabItem) tabItem.remove();

            // Xóa tab content
            const tabContent = document.getElementById(partId);
            if (tabContent) tabContent.remove();

            // Xóa accordion summary
            const summaryItem = document.querySelector(`#summary-exam-${partId}-label`)?.closest('.accordion-item');
            if (summaryItem) summaryItem.remove();

            // Gọi sắp xếp lại ID
            reorderParts();

            // Nếu cái vừa xoá là active, active tab đầu tiên
            if (wasActive) {
                const firstTabBtn = document.querySelector('.nav-link');
                const firstTabPane = document.querySelector('.tab-pane');

                if (firstTabBtn) firstTabBtn.classList.add('active');
                if (firstTabPane) firstTabPane.classList.add('active');
            }
        }

        // TODO: Sắp xếp lại ID của các phần tử sau khi xoá
        function reorderParts() {
            const tabItems = document.querySelectorAll('.nav-tabs .nav-item');
            const idMap = new Map();

            // === Bước 1: Tạo mapping oldId -> newId dựa trên <li id="part-x-tab-item">
            tabItems.forEach((item, index) => {
                const oldLiId = item.id;
                const oldId = oldLiId.replace('-tab', '');
                const newId = `part-${index + 1}`;
                idMap.set(oldId, newId);
            });
            partCount = tabItems.length;

            console.log('ID Mapping:', Array.from(idMap.entries()));
            // Bước 2: Áp dụng update cho mỗi phần tử theo idMap
            idMap.forEach((newId, oldId) => {
                updateTabHeader(oldId, newId);
                updateTabContent(oldId, newId);
                updateSummaryAccordion(oldId, newId);
            });
        }

        // TODO: Update các phần tử đã có trong tab content và summary accordion
        function updateTabHeader(oldId, newId) {
            console.log(`1.Updating tab header from ${oldId} to ${newId}`);
            const tab = document.getElementById(`${oldId}-tab`);
            if (!tab) return;

            tab.id = `${newId}-tab`;

            const btn = tab.querySelector('button');
            const x = tab.querySelector('span');

            btn.innerText = `Part ${newId.split('-')[1]}`;
            btn.setAttribute('data-tw-target', `#${newId}`);
            btn.setAttribute('aria-controls', newId);
            btn.setAttribute('aria-labelledby', `${newId}-tab`);

            if (x) x.setAttribute('onclick', `removePart('${newId}')`);
        }

        function updateTabContent(oldId, newId) {
            const el = document.getElementById(oldId);
            if (!el) return;

            el.id = newId;
            el.setAttribute('aria-labelledby', `${newId}-tab`);
        }

        function updateSummaryAccordion(oldId, newId) {
            const collapse = document.getElementById(`summary-exam-${oldId}-collapse`);
            if (!collapse) return;

            const header = collapse.previousElementSibling;
            const btn = header.querySelector('button');

            const labelId = `summary-exam-${newId}-label`;
            const collapseId = `summary-exam-${newId}-collapse`;

            header.id = labelId;
            btn.setAttribute('data-tw-target', `#${collapseId}`);
            btn.setAttribute('aria-controls', collapseId);

            collapse.id = collapseId;
            collapse.setAttribute('aria-labelledby', labelId);
        }

        // TODO: edit nội dung của part
        function toggleEdit(btn) {
            const container = btn.closest('.part-content');
            const input = container.querySelector('.part-content-input');

            if (input.hasAttribute('readonly')) {
                input.removeAttribute('readonly');
                input.focus();
                btn.classList.remove('btn-secondary');
                btn.classList.add('btn-primary');
                btn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i>';

                // Khi blur thì tự gọi lại toggleEdit để save
                input.addEventListener('blur', function handleBlur() {
                    // Xóa sự kiện blur sau 1 lần dùng để tránh lặp
                    input.removeEventListener('blur', handleBlur);
                    toggleEdit(btn);
                });


            } else {
                input.setAttribute('readonly', true);
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-secondary');
                btn.innerHTML = '<i class="fa-solid fa-pen-to-square"></i>';

            }
        }

        // TODO: Xử lý checkbox câu hỏi nằm trong content
        function handleExtractQuestions(checkbox) {
            console.log('Checkbox clicked:', checkbox.checked);
            if (!checkbox.checked) return;

            // Lấy nội dung HTML từ TinyMCE
            const editor = tinymce.get(document.querySelector('.content-editor').id);
            const content = editor.getContent();

            // Tạo DOM ảo để xử lý
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = content;

            // Tìm tất cả các input là câu hỏi
            const questionInputs = tempDiv.querySelectorAll('input.test-panel__input-answer');

            // Gán name và log ra
            questionInputs.forEach((input, i) => {
                input.setAttribute('name', 'questions[]');
                console.log(`Câu hỏi ${i + 1}:`, input.outerHTML);
            });

            // Optional: Nếu muốn cập nhật lại nội dung vào TinyMCE (sau khi thêm name[])
            editor.setContent(tempDiv.innerHTML);
        }

        function handleQuestionTypeChange(select) {
            const selectedOption = select.options[select.selectedIndex];
            const rawConfig = selectedOption.dataset.config;
            const configContainer = document.getElementById('question-config-container');

            console.log(rawConfig)
            console.log('type rawConfig:', typeof rawConfig);

            try {
                const configs = JSON.parse(rawConfig);
                console.log('Parsed configs:', configs);
                configContainer.innerHTML = ''; // clear cũ

                configs.forEach(conf => {
                    console.log('Config:', conf);
                    const wrapper = document.createElement('div');
                    wrapper.className = 'mb-4';

                    const label = document.createElement('label');
                    label.className = 'form-label font-semibold';
                    label.textContent = conf.description || conf.key;

                    // Check nếu value là JSON array hợp lệ → select
                    let inputEl;

                    console.log('Config value:', conf.value);
                    if(conf.value){

                        const values = JSON.parse(conf.value);
                        console.log('Parsed values:', values);
                        if (Array.isArray(values) && values.length > 0) {
                            // Nếu là mảng, tạo select
                            console.log('Creating select input for values:', values);
                            inputEl = document.createElement('select');
                            inputEl.name = `config[${conf.key}]`;
                            inputEl.className = 'form-select mt-1';

                            values.forEach(val => {
                                const option = document.createElement('option');
                                option.value = val;
                                option.textContent = val;
                                inputEl.appendChild(option);
                            });
                        }
                    }

                    if (!inputEl) {
                        console.log("X")
                        inputEl = document.createElement('input');
                        inputEl.name = `config[${conf.key}]`;
                        inputEl.type = 'text';
                        inputEl.className = 'form-control mt-1';
                    }

                    wrapper.appendChild(label);
                    wrapper.appendChild(inputEl);
                    configContainer.appendChild(wrapper);
                });

            } catch (e) {
                console.error('Lỗi phân tích config JSON:', e);
            }
        }
    </script>
@endsection
