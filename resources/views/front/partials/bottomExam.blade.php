<div id="mainContent" class="p-3 flex justify-between items-stretch text-sm bg-white border-t-2 border-gray-300 w-full">
    @foreach($exam->parts as $part)
        <div id="preview-part-{{$part->id}}" data-total="{{$part->num_question}}" class="partQuestion grid-cols-1 flex justify-center items-center border py-2 px-5 rounded-xl cursor-pointer
            {{$loop->index == 0 ? 'border-green-700' : 'border-gray-300'}}">
            <h3 class="text-lg font-medium w-16 text-green-700">{{$part->name}}</h3>
            <div class="info italic {{$loop->index == 0 ? 'hidden' : ''}} ">
                <span>0</span> / <span class="numQuestion">{{$part->num_question}}</span> câu hỏi đã hoàn thành
            </div>
            <div class="questionContainer flex gap-1 {{$loop->index == 0 ? 'block' : 'hidden'}}">
            </div>
        </div>
    @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Xử lý sự kiện preview - part tương ứng
        const buttons = document.querySelectorAll('.partQuestion');
        const parts = document.querySelectorAll('.partContent');

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.id.replace('preview-', ''); // Lấy phần 'part-1', 'part-2'...

                // Ẩn tất cả
                parts.forEach(part => part.classList.add('hidden'));

                // Hiện đúng phần tương ứng
                const selectedPart = document.getElementById(id);
                if (selectedPart) {
                    selectedPart.classList.remove('hidden');
                }
            });
        });


        // Xử lý sự kiện đánh số và click cho từng phần câu hỏi ở bottom
        let startIndex = 1;

        // Render các nút preview
        document.querySelectorAll('.partQuestion').forEach(block => {
            const num = parseInt(block.querySelector('.numQuestion')?.textContent || 0);
            const container = block.querySelector('.questionContainer');

            for (let i = 0; i < num; i++) {
                const p = document.createElement('p');
                p.textContent = startIndex + i;
                p.className = "preview_status w-8 h-8 flex justify-center items-center border rounded-full border-gray-300 hover:border-green-700 hover:text-green-700 cursor-pointer transition-all duration-500 ease-in-out";
                p.setAttribute('data-preview', startIndex + i); // sửa lại đúng số câu
                container.appendChild(p);
            }

            startIndex += num;
        });

        document.querySelectorAll('.preview-input').forEach((el, index) => {
            el.setAttribute('data-index', index + 1);
        });
        document.querySelectorAll('.question-item').forEach((el, index) => {
            el.setAttribute('data-question', index + 1);
        });

        const partBlocks = document.querySelectorAll('.partQuestion');
        partBlocks.forEach(block => {
            block.addEventListener('click', () => {
                partBlocks.forEach(part => {
                    const info = part.querySelector('.info');
                    const container = part.querySelector('.questionContainer');

                    if (part === block) {
                        info.classList.add('hidden');
                        container.classList.remove('hidden');

                        part.classList.remove('border-gray-300');
                        part.classList.add('border-green-700');
                    } else {
                        info.classList.remove('hidden');
                        container.classList.add('hidden');

                        part.classList.remove('border-green-700');
                        part.classList.add('border-gray-300');
                    }
                });
            });
        });

        // xử lý sự kiện kéo thả để thay đổi kích thước giữa hai lane
        const containers = document.querySelectorAll('.resizable-container');
        containers.forEach(container => {
            const resizer = container.querySelector('.resizer');
            const leftPane = container.querySelector('.leftPane');

            let isDragging = false;

            resizer.addEventListener('mousedown', (e) => {
                isDragging = true;
                document.body.style.cursor = 'col-resize';
            });

            document.addEventListener('mousemove', (e) => {
                if (!isDragging) return;

                const containerRect = container.getBoundingClientRect();
                const offsetX = e.clientX - containerRect.left;
                const containerWidth = containerRect.width;

                const leftWidthPercent = (offsetX / containerWidth) * 100;
                if (leftWidthPercent < 10 || leftWidthPercent > 90) return;

                leftPane.style.width = `${leftWidthPercent}%`;
            });

            document.addEventListener('mouseup', () => {
                isDragging = false;
                document.body.style.cursor = 'default';
            });
        });


        // Gắn sự kiện change + input cho tất cả các input
        document.querySelectorAll('.preview-input').forEach(input => {
            input.addEventListener('change', handleInputChange);
            input.addEventListener('input', handleInputChange);
        });

        function handleInputChange(e) {
            const input = e.target;
            const questionItem = input.closest('.question-item');
            const questionId = questionItem?.getAttribute('data-question');

            if (!questionId) return;

            const preview = document.querySelector(`.preview_status[data-preview="${questionId}"]`);
            if (!preview) return;

            const allInputs = questionItem.querySelectorAll('input');
            let isAnswered = false;

            allInputs.forEach(inp => {
                if ((inp.type === 'radio' || inp.type === 'checkbox') && inp.checked) {
                    isAnswered = true;
                }
                if (inp.type === 'text' && inp.value.trim() !== '') {
                    isAnswered = true;
                }
            });

            if (isAnswered) {
                preview.classList.add('bg-[#d6e4da]', 'text-green-700',);
                preview.classList.remove('bg-white', 'border-gray-300');
            } else {
                preview.classList.remove('bg-[#d6e4da]', 'text-green-700');
                preview.classList.add('bg-white','border-gray-300');
            }

            updateCompletedCount();
        }

        // Xử lý scroll đến câu hỏi khi click vào preview_status
        document.querySelectorAll('.preview_status').forEach(preview => {
            preview.addEventListener('click', () => {
                const index = preview.getAttribute('data-preview');
                const questionEl = document.querySelector(`.question-item[data-question="${index}"]`);
                if (questionEl) {
                    questionEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    // Optional: highlight hoặc animate nhẹ để người dùng nhận ra
                    questionEl.classList.add('ring', 'ring-green-500', 'p-5', 'rounded-lg');
                    setTimeout(() => {
                        questionEl.classList.remove('ring', 'ring-green-500', 'p-5', 'rounded-lg');
                    }, 600);
                }
            });
        });

        // Đếm số câu đã hoàn thành trong mỗi phần
        function updateCompletedCount() {
            document.querySelectorAll('.partQuestion').forEach(part => {
                const info = part.querySelector('.info');
                const completed = part.querySelectorAll('.preview_status').length
                    ? Array.from(part.querySelectorAll('.preview_status')).filter(p =>
                        p.classList.contains('bg-[#d6e4da]')
                    ).length
                    : 0;
                const total = parseInt(part.getAttribute('data-total') || 0);

                if (info) {
                    if (completed === total) {
                        info.innerHTML = '<span class="text-green-600">Đã hoàn thành</span>';
                    } else {
                        info.innerHTML = `<span class="text-yellow-500">${completed}</span> / <span class="numQuestion">${total}</span> câu hỏi đã hoàn thành`;
                    }
                }
            });
        }

        // Gọi hàm để cập nhật số lượng câu đã hoàn thành khi trang load
        document.getElementById('openPreview').addEventListener('click', () => {
            const tableCells = document.querySelectorAll('#preview_modal table td');
            const answersMap = {};

            document.querySelectorAll('.question-item').forEach(item => {
                const questionNumber = item.getAttribute('data-question');
                const inputs = item.querySelectorAll('input');
                let answerText = '';

                inputs.forEach(input => {
                    if ((input.type === 'radio' || input.type === 'checkbox') && input.checked) {
                        const labelText = input.closest('.answer-config-item')?.innerText?.trim() || input.value;
                        const firstChar = labelText.trim().charAt(0);
                        answerText += firstChar + ', ';
                    }

                    if (input.type === 'text' && input.value.trim() !== '') {
                        answerText += input.value.trim() + ', ';
                    }
                });

                answersMap[questionNumber] = answerText.replace(/,\s*$/, '') || 'Chưa trả lời';
            });

            // Gán vào table đã render sẵn (dựa theo Q1, Q2,...)
            tableCells.forEach(cell => {
                const match = cell.textContent.match(/Q(\d+):/);
                if (match) {
                    const qNum = match[1];
                    if (answersMap[qNum]) {
                        cell.innerHTML = `Q${qNum}: <span class="text-green-700 text-base">${answersMap[qNum]}</span>`;
                    }
                }
            });
        });

        // Gọi lần đầu khi trang load (trong TH có dữ liệu trước)
        updateCompletedCount();
    });
</script>
