@extends('layouts.exam')
@section('title', 'Listening Exam')

@section('content')
 <div>
     <!-- Nội dung chính -->
     <div id="mainContent" class="flex-1 transition-all duration-300 ease-in-out">
         <div class="flex items-center gap-4 p-4 bg-white shadow rounded-lg w-full pt-32">
             <!-- Controls -->
             <div class="flex items-center gap-4">
                 <svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                      viewBox="0 0 24 24" fill="none" stroke="#6b7280"
                      stroke-width="1.5" stroke-linecap="butt" stroke-linejoin="round">
                     <path d="M2.5 2v6h6M2.66 15.57a10 10 0 1 0 .57-8.38"/>
                     <text x="12" y="16" text-anchor="middle" font-size="10"
                           fill="#6b7280" stroke="#6b7280" stroke-width="0.75">5</text>
                 </svg>
                 <div class="bg-cyan-500 w-10 h-10 rounded-full flex justify-center items-center cursor-pointer pl-1">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#fff" stroke="#fff" stroke-width="2" stroke-linecap="butt" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                 </div>
                 <svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
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
             <span class="text-sm text-gray-600">-20:18</span>

             <!-- Progress bar -->
             <input type="range" class="w-full h-[6px] accent-cyan-400 bg-gray-500 rounded"/>

             <!-- Volume -->
             <div class="flex items-center gap-2">
                 <span class="text-cyan-500">🔊</span>
                 <input type="range" class="w-24 h-2 accent-cyan-400 bg-cyan-100 rounded" />
             </div>

             <!-- Source -->
             <select class="border rounded px-2 py-1 text-sm">
                 <option>Source 1</option>
                 <option>Source 2</option>
             </select>
         </div>
     </div>

     <div class="test-1">1</div>
     <div class="test-1">2</div>
     <div class="test-1">3</div>
     <div class="test-1">4</div>
     <div class="test-1">5</div>
 </div>

 <script>
     document.querySelectorAll('.test-1').forEach((el, index) => {
         el.setAttribute('data-index', index + 1);
     });

     // let startIndex = 1;
     // document.querySelectorAll('.partQuestion').forEach(block => {
     //     const num = parseInt(block.querySelector('.numQuestion')?.textContent || 0);
     //     const container = block.querySelector('.questionContainer');
     //
     //     for (let i = 0; i < num; i++) {
     //         const p = document.createElement('p');
     //         p.textContent = startIndex + i;
     //         p.className = "w-8 h-8 flex justify-center items-center border rounded-full border-gray-300 hover:border-green-700 hover:text-green-700 cursor-pointer transition-all duration-500 ease-in-out";
     //
     //         container.appendChild(p);
     //     }
     //
     //     startIndex += num;
     // });
     //
     // const partBlocks = document.querySelectorAll('.partQuestion');
     //
     // partBlocks.forEach(block => {
     //     block.addEventListener('click', () => {
     //         partBlocks.forEach(part => {
     //             const info = part.querySelector('.info');
     //             const container = part.querySelector('.questionContainer');
     //
     //             if (part === block) {
     //                 info.classList.add('hidden');
     //                 container.classList.remove('hidden');
     //
     //                 part.classList.remove('border-gray-300');
     //                 part.classList.add('border-green-700');
     //             } else {
     //                 info.classList.remove('hidden');
     //                 container.classList.add('hidden');
     //
     //                 part.classList.remove('border-green-700');
     //                 part.classList.add('border-gray-300');
     //             }
     //         });
     //     });
     // });
 </script>
@endsection
