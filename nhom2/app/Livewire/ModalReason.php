<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;

class ModalReason extends Component
{
    public $orderId;
    public $reason;

    protected $listeners = [
        'showCancelReasonModal' => 'showModal',
    ];

    public function showModal($orderId)
    {
        // Gán ID đơn hàng khi sự kiện được phát ra
        $this->orderId = $orderId;
        $this->dispatchBrowserEvent('openCancelOrderModal');
    }

    public function saveReason()
    {
        // Giả sử bạn đã có cơ chế lưu lý do hủy trong cơ sở dữ liệu
        // Lưu lý do hủy và đóng modal
        $this->dispatchBrowserEvent('closeCancelOrderModal');
    }

    public function render()
    {
        return view('livewire.cancel-order-modal');
    }
}