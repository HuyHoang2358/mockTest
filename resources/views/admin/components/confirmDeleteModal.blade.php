@if(isset($routeDelete))
    <form method="POST" action="{{ $routeDelete }}" id="delete-object-confirm-form" class="modal" tabindex="-1" aria-hidden="true">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="px-5 pt-4 py-2  text-center flex justify-between items-center">
                        <p class="font-bold text-lg">Xác nhận xóa</p>
                        <button type="button" data-tw-dismiss="modal" class="p-2 ">
                            <i data-lucide="x-circle" class="w-6 h-6 text-danger"></i>
                        </button>
                    </div>
                    <div class="px-5 pb-4">
                        <div class="text-slate-500 mt-2">
                            <p class="font-semibold">Bạn có muốn xóa <span id="del-object-name" class="font-bold text-red-600">xxxx</span>?</p>
                            <p class="text-gray-500 text-xs mt-1">Hành động này sẽ không thể hoàn tác.</p>
                        </div>
                        <input type="hidden" id="del-object-id" name="del-object-id">
                    </div>
                    {{--  @if ($routeDelete == route('admin.account.destroy'))
                          <div class="pb-4">
                              <div class="px-5 relative perfect-sight">
                                  <input required id="password" name="password" type="password" class="form-control mt-2" placeholder="Nhập mật khẩu hiện tại để tiếp tục">
                                  <i class="absolute toggle-password-on hidden" style="top: 30%; right: 6%; cursor: pointer;" data-lucide="eye"></i>
                                  <i class="absolute toggle-password-off hidden" style="top: 30%; right: 6%; cursor: pointer;" data-lucide="eye-off"></i>
                              </div>
                          </div>
                      @endif--}}

                    <div class="px-5 pb-8 text-center flex justify-end items-center">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Hủy</button>
                        <button type="submit" id="deleteButton" class="btn btn-danger">Xóa </button>
                        <button type="button" id="deletingButton" class="btn btn-danger hidden" disabled>
                            Deleting <i data-loading-icon="puff" data-color="white" class="w-4 h-4 ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endif
<script>
    function openConfirmDeleteObjectForm(name, id) {
        document.getElementById('del-object-name').textContent = name;
        document.getElementById('del-object-id').value = id;
    }
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('deleteButton')?.addEventListener('click', function (e) {
            const btn = e.currentTarget;

            // Disable button
            btn.disabled = true;
            btn.classList.add('cursor-not-allowed', 'opacity-70', 'hidden');

            document.getElementById('deletingButton').classList.remove('hidden');
            // submit the form
            document.getElementById('delete-object-confirm-form').submit();
        });
    });

</script>
