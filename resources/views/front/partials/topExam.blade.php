<div class="grid grid-cols-3 h-16 bg-white items-center px-10 w-full border-b-2 border-gray-200">
    <!-- logo -->
    <div class="col-span-1">
        <a href="#">
            <span class="logo__text text-[#124d59] text-xl font-semibold ml-3"> MockTest </span>
        </a>
    </div>

    <!-- Time left -->
    <div class="col-span-1 flex flex-col items-center text-[#124d59] font-semibold">
        <div class="text-2xl">
            <i class="fa-regular fa-hourglass-half mr-2"></i>
            <span id="time-minus">00</span>
            <span>:</span>
            <span id="time-second">00</span>
        </div>
        <p>Thời gian còn lại</p>
    </div>

    <!-- Right buttons -->
    <div class="flex text-2xl gap-3 items-center justify-end">
        <!-- Nút mở slide -->
        <button id="togglePanelBtn" type="button" class="tooltip text-gray-500 hover:text-[#124d59]" data-theme="light" title="Ghi chú">
            <i class="fa-solid fa-pen-nib"></i>
        </button>

        <!-- Slide panel -->
        <div id="slidePanel"
             class="fixed top-[68px] right-0 w-96 h-[calc(100vh-68px)] bg-white shadow-lg transform translate-x-full transition-transform duration-500 ease-in-out z-50 flex-1 overflow-y-auto">
            <div class="flex justify-between items-center p-4 border-b">
                <h2 class="text-xl font-semibold text-[#124d59]">Ghi chú</h2>
                <button id="closePanelBtn" data-theme="light" title="Đóng ghi chú" class="text-gray-500 hover:text-red-500 text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Ô tìm kiếm -->
            <div class="p-4 relative w-full text-base">
                <input type="text" placeholder="Tìm kiếm ghi chú..." class="w-full mt-1 form-control"/>
                <i class="fa-solid fa-magnifying-glass text-lg absolute top-8 right-8 text-[#124d59]"></i>
            </div>

            <!-- Nội dung ghi chú-->
            <div id="noteContainer" class="px-5 overflow-y-auto h-[calc(100vh-143px-64px)]">

            </div>
        </div>

        <!-- Nút fullscreen -->
        <button id="fullscreenToggle" class="transition-all duration-300 ease-in-out tooltip text-gray-500 hover:text-[#124d59]" data-theme="light" title="Toàn màn hình">
            <!-- Icon: Enter Fullscreen -->
            <span id="enterIcon"> <i class="fa-solid fa-expand"></i> </span>
            <!-- Icon: Exit Fullscreen -->
            <span id="exitIcon" class="hidden"> <i class="fa-solid fa-compress"></i> </span>
        </button>


        <!-- review -->
        <button id="openPreview" class="flex justify-start gap-2 font-normal items-center btn btn-secondary text-base rounded-full text-gray-500 hover:text-[#124d59]">
            <i class="fa-solid fa-list-check"></i>
            <span>Xem lại</span>
        </button>

        <div class="flex justify-start gap-2 items-center rounded-full text-base btn btn-primary">
            <p>Nộp bài</p>
            <i class="fa-solid fa-paper-plane text-sm"></i>
        </div>

        <!-- Preview answer modal -->
        <div id="preview_modal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div id="modalContent" class="bg-white p-12 rounded-2xl shadow-lg w-[1200px] relative transition-all duration-300 transform opacity-0 translate-y-10">
                <!-- Close Button (X) -->
                <button class="closePreview absolute duration-150 text-2xl top-5 right-8 text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <h2 class="text-3xl font-medium mb-2 text-center text-[#124d59]">Bảng xem qua đáp án</h2>
                <p class="text-sm mb-4 text-center text-light-gray">* Đây chỉ là bảng xem qua đáp án của bạn, không thể thay đổi đáp án ở đây</p>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border border-gray-400 border-collapse">
                        <tbody>
                        <script>
                            let html = '';
                            for (let i = 1; i <= 40; i++) {
                                if ((i - 1) % 4 === 0) html += '<tr>';
                                html += `
                              <td class="border text-[18px] font-medium border-gray-300 px-5 py-2 align-middle">
                                Q${i}:
                              </td>`;
                                if (i % 4 === 0) html += '</tr>';
                            }
                            document.write(html);
                        </script>
                        </tbody>
                    </table>
                </div>
                <div class="closePreview flex w-full justify-center mt-10"><button class="text-center font-medium text-white bg-[#124d59] w-fit px-12 py-2 rounded-full text-lg hover:scale-105">Đóng</button></div>
            </div>
        </div>
    </div>

    <!-- Popup khi bôi đen -->
    <div id="selectionPopup" class="hidden absolute z-50 bg-white border border-gray-300 rounded shadow-md px-3 py-2 text-sm space-x-4
     after:content-[''] after:absolute after:bottom-[-6px] after:left-1/2 after:-translate-x-1/2
     after:border-x-8 after:border-x-transparent
     after:border-t-8 after:border-t-white after:z-[-1]">
        <button id="popupNote" class="text-blue-600 hover:underline">Note</button>
        <button id="popupHighlight" class="text-yellow-600 hover:underline">Highlight</button>
    </div>

    <!-- Popup xóa highlight -->
    <div id="deleteHighlight" class="hidden absolute z-50 bg-white border border-gray-300 rounded shadow-md px-3 py-2 text-sm space-x-4
            after:content-[''] after:absolute after:top-full after:left-1/2 after:-translate-x-1/2
            after:border-x-8 after:border-x-transparent
            after:border-t-8 after:border-t-white">
        <button class="text-red-600 hover:underline">Xóa Highlight</button>
    </div>

    <!-- Popup ghi chú sau khi chọn "Note" -->
    <div  id="notePopup" class="hidden absolute bg-white border border-gray-300 shadow-xl rounded-md p-4 z-50 w-64">
        <textarea id="noteTextarea" rows="3" placeholder="Ghi chú cho đoạn đã chọn..." class="w-full border rounded px-2 py-1 focus:ring-[#124d59] focus:outline-none"></textarea>
        <div class="flex justify-end gap-2 mt-2">
            <button id="cancelNote" class="px-3 py-1 border rounded text-gray-600 hover:bg-gray-100">Hủy</button>
            <button id="saveNote" class="px-3 py-1 bg-[#124d59] text-white rounded hover:bg-[#0e3f47]">Lưu</button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const slidePanel = document.getElementById('slidePanel');
            const toggleBtn = document.getElementById('togglePanelBtn');
            const closeBtn = document.getElementById('closePanelBtn');
            const mainContent = document.getElementById('mainContent'); // phần nội dung chính

            let isPanelOpen = false;

            // Toggle khi nhấn icon
            toggleBtn.addEventListener('click', () => {
                isPanelOpen = !isPanelOpen;

                if (isPanelOpen) {
                    slidePanel.classList.remove('translate-x-full');
                    mainContent.classList.add('mr-[380px]'); // đẩy nội dung qua trái đúng bằng width panel
                } else {
                    slidePanel.classList.add('translate-x-full');
                    mainContent.classList.remove('mr-[380px]');
                }
            });

            // Đóng khi nhấn dấu "×"
            closeBtn.addEventListener('click', () => {
                isPanelOpen = false;
                slidePanel.classList.add('translate-x-full');
                mainContent.classList.remove('mr-[380px]');
            });

            // Xử lý toggle dropdown menu
            document.querySelectorAll(".toggleMenu").forEach((btn) => {
                btn.addEventListener("click", function (e) {
                    e.stopPropagation();
                    const dropdown = this.nextElementSibling;
                    document.querySelectorAll(".dropdownMenu").forEach(menu => {
                        if (menu !== dropdown) menu.classList.add("hidden");
                    });
                    dropdown.classList.toggle("hidden");
                });
            });

            // Ẩn dropdown nếu click bên ngoài
            document.addEventListener("click", () => {
                document.querySelectorAll(".dropdownMenu").forEach(menu => {
                    menu.classList.add("hidden");
                });
            });

            // Xử lý "Sửa" ghi chú
            document.querySelectorAll(".editBtn").forEach(btn => {
                btn.addEventListener("click", function () {
                    const parent = this.closest(".border-b");
                    const displayText = parent.querySelector(".displayText");
                    const editArea = parent.querySelector(".editArea");
                    const input = editArea.querySelector(".editInput");

                    // Hiện khu sửa và ẩn text
                    displayText.classList.add("hidden");
                    editArea.classList.remove("hidden");

                    // Lấy nội dung text cho vào input
                    input.value = displayText.textContent.trim();
                });
            });

            // Xử lý "Lưu" ghi chú sau khi sửa
            document.querySelectorAll(".editArea button:nth-child(2)").forEach(btn => {
                btn.addEventListener("click", function () {
                    const parent = this.closest(".border-b");
                    const displayText = parent.querySelector(".displayText");
                    const input = parent.querySelector(".editInput");
                    const editArea = parent.querySelector(".editArea");

                    const newText = input.value.trim();
                    if (newText !== "") {
                        displayText.textContent = newText;
                    }

                    // Ẩn khu sửa, hiện lại văn bản
                    editArea.classList.add("hidden");
                    displayText.classList.remove("hidden");
                });
            });

            // Hủy sửa ghi chú
            document.querySelectorAll(".editArea button:nth-child(1)").forEach(btn => {
                btn.addEventListener("click", function () {
                    const parent = this.closest(".border-b");
                    parent.querySelector(".editArea").classList.add("hidden");
                    parent.querySelector(".displayText").classList.remove("hidden");
                });
            });

            // Xử lý "Xóa" ghi chú
            document.querySelectorAll(".deleteBtn").forEach(btn => {
                btn.addEventListener("click", function () {
                    const parent = this.closest(".border-b");
                    parent.querySelector(".confirmDelete").classList.remove("hidden");
                });
            });

            // Nút "Có"
            document.querySelectorAll(".confirmYes").forEach(btn => {
                btn.addEventListener("click", function () {
                    this.closest(".border-b").remove();
                });
            });

            // Nút "Không"
            document.querySelectorAll(".confirmNo").forEach(btn => {
                btn.addEventListener("click", function () {
                    this.closest(".confirmDelete").classList.add("hidden");
                });
            });

            // Hủy xóa
            document.querySelectorAll(".confirmDelete button:nth-child(2)").forEach(btn => {
                btn.addEventListener("click", function () {
                    const parent = this.closest(".border-b");
                    parent.querySelector(".confirmDelete").classList.add("hidden");
                });
            });

            // Xử lý fullscreen
            const fullscreenBtn = document.getElementById("fullscreenToggle");
            const enterIcon = document.getElementById("enterIcon");
            const exitIcon = document.getElementById("exitIcon");

            fullscreenBtn.addEventListener("click", () => {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen();
                    enterIcon.classList.add("hidden");
                    exitIcon.classList.remove("hidden");
                } else {
                    document.exitFullscreen();
                    enterIcon.classList.remove("hidden");
                    exitIcon.classList.add("hidden");
                }
            });

            // Xử lý sự kiện Preview
            const openPreview = document.getElementById('openPreview');
            const closeButtons = document.querySelectorAll('.closePreview');
            const modal = document.getElementById('preview_modal');
            const modalContent = document.getElementById('modalContent'); // thêm ID cho div content

            openPreview.addEventListener('click', function () {
                modal.classList.remove('hidden');

                requestAnimationFrame(() => {
                    modalContent.classList.remove('opacity-0', 'translate-y-10');
                    modalContent.classList.add('opacity-100', 'translate-y-0');
                });
            });
            function closeModal() {
                modalContent.classList.remove('opacity-100', 'translate-y-0');
                modalContent.classList.add('opacity-0', 'translate-y-10');

                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
            closeButtons.forEach(button => {
                button.addEventListener('click', closeModal);
            });
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

            // Tham chiếu đến popup đã có sẵn
            const selectionPopup = document.getElementById("selectionPopup");
            const notePopup = document.getElementById("notePopup");
            const noteTextarea = document.getElementById("noteTextarea");
            const cancelNote = document.getElementById("cancelNote");
            const saveNote = document.getElementById("saveNote");

            // Khi bôi đen văn bản
            document.addEventListener("mouseup", function (e) {
                const selection = window.getSelection();
                const text = selection.toString().trim();
                const selectionPopup = document.getElementById("selectionPopup");

                // Nếu không có text hoặc không phải là vùng chọn thật
                if (text.length === 0 || selection.rangeCount === 0) {
                    selectionPopup.classList.add("hidden");
                    return;
                }

                const range = selection.getRangeAt(0);

                // Kiểm tra nếu điểm bắt đầu hoặc kết thúc nằm trong phần đã highlight
                const startContainer = range.startContainer;
                const endContainer = range.endContainer;

                const isInsideHighlight = (node) => {
                    while (node) {
                        if (node.classList && node.classList.contains("highlightedText")) {
                            return true;
                        }
                        node = node.parentNode;
                    }
                    return false;
                };

                if (isInsideHighlight(startContainer) || isInsideHighlight(endContainer)) {
                    selectionPopup.classList.add("hidden");
                    return;
                }

                // Hiển thị popup bình thường
                const rect = range.getBoundingClientRect();
                window.currentSelectionRange = range.cloneRange();

                selectionPopup.classList.remove("hidden");
                selectionPopup.classList.add("invisible");

                const popupWidth = selectionPopup.offsetWidth;
                const popupHeight = selectionPopup.offsetHeight;

                selectionPopup.style.top = `${window.scrollY + rect.top - popupHeight - 8}px`;
                selectionPopup.style.left = `${window.scrollX + rect.left + rect.width / 2 - popupWidth / 2}px`;

                selectionPopup.classList.remove("invisible");
            });

            // Nhấn Highlight
            document.getElementById("popupHighlight").addEventListener("click", () => {
                if (window.currentSelectionRange) {
                    const span = document.createElement("span");
                    span.style.backgroundColor = "yellow";
                    span.classList.add("highlightedText", "cursor-pointer", "px-1");
                    span.textContent = window.currentSelectionRange.toString();
                    window.currentSelectionRange.deleteContents();
                    window.currentSelectionRange.insertNode(span);

                    selectionPopup.classList.add("hidden");
                    window.getSelection().removeAllRanges();
                }
            });

            // Xuất hiện popup xóa highlight
            document.addEventListener("click", function (e) {
                const highlight = e.target.closest("span.highlightedText");
                const popup = document.getElementById("deleteHighlight");

                if (highlight) {
                    e.stopPropagation();
                    const rect = highlight.getBoundingClientRect();
                    popup.classList.remove("hidden");

                    // Canh giữa popup phía trên đoạn text
                    popup.style.top = `${window.scrollY + rect.top - popup.offsetHeight - 8}px`;
                    popup.style.left = `${window.scrollX + rect.left + rect.width / 2 - popup.offsetWidth / 2}px`;

                    // Lưu lại đoạn được click để xóa sau
                    window.currentHighlightedSpan = highlight;
                } else {
                    popup.classList.add("hidden");
                }
            });

            // Xóa highlight khi nhấn nút trong popup
            document.querySelector("#deleteHighlight button").addEventListener("click", () => {
                const span = window.currentHighlightedSpan;
                if (span) {
                    const textNode = document.createTextNode(span.textContent);
                    span.parentNode.replaceChild(textNode, span);
                    document.getElementById("deleteHighlight").classList.add("hidden");
                    window.currentHighlightedSpan = null;
                }
            });

            // Nhấn Note
            document.getElementById("popupNote").addEventListener("click", (e) => {
                e.stopPropagation();

                const rect = window.currentSelectionRange.getBoundingClientRect();

                // Tạm hiển thị popup để lấy kích thước
                notePopup.classList.remove("hidden");
                notePopup.classList.add("invisible");

                const popupWidth = notePopup.offsetWidth;
                const popupHeight = notePopup.offsetHeight;

                // Đặt vị trí: bên dưới và giữa vùng bôi đen
                notePopup.style.top = `${window.scrollY + rect.bottom + 8}px`;
                notePopup.style.left = `${window.scrollX + rect.left + rect.width / 2 - popupWidth / 2}px`;

                // Hiển thị thực sự
                notePopup.classList.remove("invisible");
                notePopup.classList.remove("hidden");

                // Ẩn popup lựa chọn
                selectionPopup.classList.add("hidden");
            });

            // Hủy ghi chú
            cancelNote.addEventListener("click", () => {
                notePopup.classList.add("hidden");
                noteTextarea.value = "";
                window.getSelection().removeAllRanges();
            });

            // Lưu ghi chú
            saveNote.addEventListener("click", () => {
                const text = noteTextarea.value.trim();
                if (window.currentSelectionRange && text !== "") {
                    const selectedText = window.currentSelectionRange.toString();

                    // Bôi đen đoạn được chọn (làm nổi bật trên trang chính)
                    const span = document.createElement("span");
                    span.textContent = selectedText;
                    span.classList.add("text-red-600", "underline", "italic", "font-medium");
                    const noteId = 'note-' + Date.now(); // id duy nhất
                    span.dataset.noteId = noteId; // gán id vào span
                    window.currentSelectionRange.deleteContents();
                    window.currentSelectionRange.insertNode(span);

                    // Tạo đoạn mới chèn vào container
                    const noteContainer = document.getElementById("noteContainer");

                    const wrapper = document.createElement("div");
                    wrapper.className = "p-2 border-gray-200 border-b";

                    wrapper.innerHTML = `
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium underline hover:text-red-500 cursor-pointer" data-note-id="${noteId}">${selectedText}</h3>
                <div class="relative inline-block text-left">
                    <button class="toggleMenu text-[#5b7188] w-8 text-xl hover:text-[#124d59] focus:outline-none">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <div class="dropdownMenu absolute right-0 w-40 bg-white border border-gray-200 rounded-md shadow-lg p-2 space-y-2 z-50 hidden transition-all duration-300 ease-in-out">
                        <button class="editBtn flex items-center w-full gap-2 px-2 py-1 rounded hover:bg-gray-100 text-sm text-gray-700">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 20H20.5M18 10L21 7L17 3L14 6M18 10L8 20H4V16L14 6M18 10L14 6"
                                      stroke="#5b7188" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg> Sửa
                        </button>
                        <button class="deleteBtn flex items-center w-full gap-2 px-2 py-1 rounded hover:bg-gray-100 text-sm text-gray-700">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 12V17" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M14 12V17" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M4 7H20" stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10"
                                      stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z"
                                      stroke="#5b7188" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>Xóa
                        </button>
                    </div>
                </div>
            </div>
            <p class="displayText text-base text-gray-500 mt-2">${text}</p>
            <div class="editArea space-y-2 mt-2 hidden">
                <input type="text" class="editInput w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-[#124d59]" />
                <div class="flex gap-2 justify-end text-sm">
                    <button class="px-4 py-1 border rounded text-gray-600 hover:bg-gray-100">Hủy</button>
                    <button class="px-4 py-1 bg-[#124d59] text-white rounded hover:bg-[#0e3f47]">Lưu</button>
                </div>
            </div>
            <div class="confirmDelete hidden bg-gray-200 px-5 py-1 mt-2 rounded-xl">
                <div class="flex justify-between items-center text-sm text-center">
                    <p class="font-medium text-gray-600">Bạn có muốn xóa?</p>
                    <div class="flex">
                        <button class="confirmYes px-3 py-1 hover:bg-red-600 hover:text-white rounded">Có</button>
                        <button class="confirmNo px-3 py-1 hover:bg-gray-400 rounded">Không</button>
                    </div>
                </div>
            </div>
        `;

                    noteContainer.appendChild(wrapper);

                    // Ẩn popup và reset
                    notePopup.classList.add("hidden");
                    noteTextarea.value = "";
                    window.getSelection().removeAllRanges();

                    // Gán lại sự kiện cho phần tử mới thêm
                    rebindNoteEvents(wrapper);
                }
            });

            function rebindNoteEvents(wrapper) {
                const displayText = wrapper.querySelector(".displayText");
                const editArea = wrapper.querySelector(".editArea");
                const input = editArea.querySelector(".editInput");

                wrapper.querySelector(".editBtn").addEventListener("click", () => {
                    input.value = displayText.textContent.trim();
                    displayText.classList.add("hidden");
                    editArea.classList.remove("hidden");
                });

                // Lưu sửa
                editArea.querySelector("button:nth-child(2)").addEventListener("click", () => {
                    const newText = input.value.trim();
                    if (newText !== "") displayText.textContent = newText;
                    displayText.classList.remove("hidden");
                    editArea.classList.add("hidden");
                });

                // Hủy sửa
                editArea.querySelector("button:nth-child(1)").addEventListener("click", () => {
                    displayText.classList.remove("hidden");
                    editArea.classList.add("hidden");
                });

                // Xóa
                wrapper.querySelector(".deleteBtn").addEventListener("click", () => {
                    wrapper.querySelector(".confirmDelete").classList.remove("hidden");
                });

                // Có
                wrapper.querySelector(".confirmYes").addEventListener("click", () => {
                    const h3 = wrapper.querySelector("h3[data-note-id]");
                    const noteId = h3 ? h3.dataset.noteId : null;

                    // Tìm và xóa span tương ứng với noteId
                    if (noteId) {
                        const spans = document.querySelectorAll(`span[data-note-id="${noteId}"]`);
                        spans.forEach(span => {
                            // Gỡ class hoặc thay thế span bằng văn bản
                            const textNode = document.createTextNode(span.textContent);
                            span.parentNode.replaceChild(textNode, span);
                        });
                    }

                    wrapper.remove(); // Xóa note khỏi noteContainer
                });

                // Không
                wrapper.querySelector(".confirmNo").addEventListener("click", () => {
                    wrapper.querySelector(".confirmDelete").classList.add("hidden");
                });

                // Dropdown menu
                wrapper.querySelector(".toggleMenu").addEventListener("click", (e) => {
                    e.stopPropagation();
                    const dropdown = wrapper.querySelector(".dropdownMenu");
                    document.querySelectorAll(".dropdownMenu").forEach(menu => {
                        if (menu !== dropdown) menu.classList.add("hidden");
                    });
                    dropdown.classList.toggle("hidden");
                });
            }

            document.addEventListener("click", (e) => {
                // Nếu click không nằm trong popup ghi chú
                if (!notePopup.contains(e.target) && !selectionPopup.contains(e.target)) {
                    notePopup.classList.add("hidden");
                }
            });
        });


        // Xử lý sự kiện đồng hồ chạy
        const leftTime = {{$leftTime}}; // thời gian còn lại tính bằng giây
        function countdown(m) {
            let t = m; // t là thời gian còn lại tính bằng giây
            setInterval(() => {
                if (t < 0) return;
                let min = String(Math.floor(t / 60)).padStart(2, '0');
                let sec = String(t % 60).padStart(2, '0');
                document.getElementById("time-minus").textContent = min;
                document.getElementById("time-second").textContent = sec;
                t--;
            }, 1000);
        }
        countdown(leftTime);
    </script>
</div>
