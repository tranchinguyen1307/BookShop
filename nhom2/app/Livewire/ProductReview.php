<?php

namespace App\Livewire;

use Livewire\Component;

use Livewire\WithPagination;
use App\Models\Review;

class ProductReview extends Component
{
    use WithPagination;

    public $productId;

    protected $paginationTheme = 'bootstrap'; 
    public function render()
    {
        $reviews = Review::with('user')
            ->where('product_id', $this->productId)
            ->latest()
            ->paginate(5);

        return view('livewire.product-review', compact('reviews'));
    }
}
