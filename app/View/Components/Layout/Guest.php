<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Guest extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $back = null,
        public $class = null
    )
    {
        $this->back = $back;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.guest');
    }
}
