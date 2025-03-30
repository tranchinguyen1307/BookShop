<?php
namespace App\View\Components\client;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
class navbar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->userEmail = Auth::check() ? Auth::user()->email : null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.navbar');
    }
}
