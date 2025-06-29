@extends('layouts.exam')
@section('title', 'Reading Exam')

@section('content')
    <div class="flex transition-all duration-300 ease-in-out">
        <!-- Nội dung chính -->
        <div id="mainContent" class="flex-1 transition-all duration-300 ease-in-out">
            <div class="flex h-screen overflow-hidden">
                <!-- Left pane -->
                <div id="leftPane" class="bg-green-50 w-1/2 min-w-[100px] max-w-[90%] overflow-auto px-10 pt-24">
                    <p>Until three months ago, life in this humble village without electricity would come to a halt after sunset. Inside his mud-and-clay home, Ganpat Jadhav's three children used to study in the dim, smoky glow of a kerosene lamp, when their monthly fuel quota of four litres dried up in just a fortnight, they had to strain their eyes using the light from a cooking fire. That all changed with the installation of low-cost, energy-efficient lamps that are powered entirely by the sun. The lights were installed by the Grameen Surya Bijli Foundation (GSBF), an Indian non-governmental organisation focused on bringing light to rural India. Some 100,000 Indian villages do not yet have electricity. The GSBF lamps use LEDs - light emitting diodes - that are four times more efficient than a normal bulb. After a $55 installation cost, solar energy lights the lamp free of charge. LED lighting, like cell phones, is another example of a technology whose low cost could allow the rural poor to leap into the 21st century.</p>
                    <p>Until three months ago, life in this humble village without electricity would come to a halt after sunset. Inside his mud-and-clay home, Ganpat Jadhav's three children used to study in the dim, smoky glow of a kerosene lamp, when their monthly fuel quota of four litres dried up in just a fortnight, they had to strain their eyes using the light from a cooking fire. That all changed with the installation of low-cost, energy-efficient lamps that are powered entirely by the sun. The lights were installed by the Grameen Surya Bijli Foundation (GSBF), an Indian non-governmental organisation focused on bringing light to rural India. Some 100,000 Indian villages do not yet have electricity. The GSBF lamps use LEDs - light emitting diodes - that are four times more efficient than a normal bulb. After a $55 installation cost, solar energy lights the lamp free of charge. LED lighting, like cell phones, is another example of a technology whose low cost could allow the rural poor to leap into the 21st century.</p>
                </div>

                <!-- Resizer -->
                <div id="resizer" class="w-[6px] h-full cursor-col-resize bg-gray-200 hover:bg-gray-300 transition-all"></div>

                <!-- Right pane -->
                <div id="rightPane" class="bg-white flex-1 overflow-auto px-10 pt-24">
                    <p>Until three months ago, life in this humble village without electricity would come to a halt after sunset. Inside his mud-and-clay home, Ganpat Jadhav's three children used to study in the dim, smoky glow of a kerosene lamp, when their monthly fuel quota of four litres dried up in just a fortnight, they had to strain their eyes using the light from a cooking fire. That all changed with the installation of low-cost, energy-efficient lamps that are powered entirely by the sun. The lights were installed by the Grameen Surya Bijli Foundation (GSBF), an Indian non-governmental organisation focused on bringing light to rural India. Some 100,000 Indian villages do not yet have electricity. The GSBF lamps use LEDs - light emitting diodes - that are four times more efficient than a normal bulb. After a $55 installation cost, solar energy lights the lamp free of charge. LED lighting, like cell phones, is another example of a technology whose low cost could allow the rural poor to leap into the 21st century.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tạo số lượng câu hỏi cho từng Part
        let startIndex = 1;
        document.querySelectorAll('.partQuestion').forEach(block => {
            const num = parseInt(block.querySelector('.numQuestion')?.textContent || 0);
            const container = block.querySelector('.questionContainer');

            for (let i = 0; i < num; i++) {
                const p = document.createElement('p');
                p.textContent = startIndex + i;
                p.className = "w-8 h-8 flex justify-center items-center border rounded-full border-gray-300 hover:border-green-700 hover:text-green-700 cursor-pointer transition-all duration-500 ease-in-out";

                container.appendChild(p);
            }

            startIndex += num;
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

        // Xử lý kéo thả để thay đổi kích thước giữa hai lane
        const resizer = document.getElementById('resizer');
        const leftPane = document.getElementById('leftPane');
        const rightPane = document.getElementById('rightPane');

        let isDragging = false;

        resizer.addEventListener('mousedown', (e) => {
            isDragging = true;
            document.body.style.cursor = 'col-resize';
        });

        document.addEventListener('mousemove', (e) => {
            if (!isDragging) return;

            const containerOffsetLeft = leftPane.parentNode.offsetLeft;
            const pointerRelativeXpos = e.clientX - containerOffsetLeft;
            const containerWidth = leftPane.parentNode.offsetWidth;

            // Tính % chiều rộng
            const leftWidth = (pointerRelativeXpos / containerWidth) * 100;
            if (leftWidth < 10 || leftWidth > 90) return; // Giới hạn

            leftPane.style.width = `${leftWidth}%`;
        });

        document.addEventListener('mouseup', () => {
            isDragging = false;
            document.body.style.cursor = 'default';
        });
    </script>
@endsection
