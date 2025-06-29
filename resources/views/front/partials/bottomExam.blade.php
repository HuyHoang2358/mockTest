<div class="py-2 px-4 flex justify-start gap-4 text-sm bg-white border-t-2 border-primary w-full overflow-x-scroll">
    @foreach($exam->parts as $part)
        <div id="preview-part-{{$part->id}}" class="part-preview flex justify-center items-center gap-2 border p-4 rounded-lg
             {{$loop->index == 0 ? 'border-primary' : ''}} bg-white text-primary">
            <h3 class="text-lg font-medium w-16">{{$part->name}}</h3>
            <div class="info italic hidden">
                <span class="text-red-600 font-semibold">0</span>
                /
                <span class="font-semibold">{{$part->num_question}}</span>
                đã hoàn thành
            </div>
            <div class="questionContainer flex gap-1">
                @foreach($part->questionGroups as $questionGroup)
                    @foreach($questionGroup->questions as $question)
                        <button class="btn rounded-full w-8 h-8 hover:bg-blue-600 hover:text-white">{{$question->number}}</button>
                    @endforeach
                @endforeach
            </div>
        </div>
    @endforeach
</div>
