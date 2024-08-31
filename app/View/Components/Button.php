<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public function __construct(
        public $type = 'button',
        public $class = null,
        public $href = null,
        public $wire = null
    )
    {
        $this->type = $type;
        $this->class = $class;
        $this->href = $href;
        $this->wire = $wire;
    }

    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
