<div>
    <!-- Modal lý do hủy -->
    <div id="cancelOrderModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nhập lý do hủy đơn hàng</h5>
                    <button type="button" class="btn-close" wire:click="$emit('closeCancelOrderModal')"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reason">Lý do hủy</label>
                        <textarea id="reason" wire:model="reason" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        wire:click="$emit('closeCancelOrderModal')">Đóng</button>
                    <button type="button" class="btn btn-danger" wire:click="saveReason">Lưu lý do</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('openCancelOrderModal', event => {
            $('#cancelOrderModal').modal('show');
        });

        window.addEventListener('closeCancelOrderModal', event => {
            $('#cancelOrderModal').modal('hide');
        });
    </script>
@endpush