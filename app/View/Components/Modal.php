<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public function __construct(
        public $trigger = "<button type='button' class='button'>Modal</button>",
        public $class = null,
        public $close = null
    )
    {
        $this->trigger = $trigger;
        $this->class = $class;
        $this->close = $close;
    }

    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
