<script src="{{ asset('assets/dist/js/app.js') }}"></script>
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
    // Count number of characters
    function handleCountNumberCharacter(inputId, countId, maxLength) {
        const input = document.getElementById(inputId);
        if (!input) {
            console.error('Input element not found', inputId);
            return;
        }
        let str = input.value;
        const number = str.length;
        if (number > maxLength) {
            str = str.substring(0, maxLength)
            input.value = str;
            document.getElementById(countId).innerText = maxLength;
        } else {
            document.getElementById(countId).innerText = number;
        }
    }


    $(document).ready(function() {
        if ($('#togglePostFields').is(':checked')) {
            $('#postFields').removeClass('hidden').addClass('flex');
        }

        // start word counter
        function updateWordCounter() {
            $('.word-counter').each(function() {

                const inputId = $(this).attr('input-to-count');
                const maxLength = $(this).attr('max-characters');
                let inputElement = $('#' + inputId);
                let inputValue = $('#' + inputId).val();

                if (inputValue.length > maxLength) {
                    inputElement.val(inputValue.substring(0, maxLength));
                    inputValue = inputElement.val();
                }

                $(this).text(inputValue.length);
            });
        }

        updateWordCounter();

        $('input').on('input', function() {
            updateWordCounter();
        });
        // end word counter

        // image eraser button
        $('.images-eraser').click(function() {
            // Clear the input value
            let input = $('#' + $(this).attr('input-to-clear'));
            input.val('');

            // Remove all img tags inside the holder div
            let holder = $('#' + $(this).attr('holder-to-clear'));
            holder.find('img').remove();

            if (holder.children().length == 0) {
                holder.append(
                    '<div class="placeholder-text text-gray-600 flex items-center justify-center rounded bg-slate-300 w-48 h-28 overflow-hidden text-center">Chưa có hình ảnh xem trước</div>'
                );
            }
        });
        //end image eraser button

        // add readonly function for img tags
        $(".readonly").on('keydown paste focus mousedown', function(e) {
            if (e.keyCode != 9) // ignore tab
                e.preventDefault();
        });
        //end add readonly function for img tags

    });


    // Init TinyCME


</script>
