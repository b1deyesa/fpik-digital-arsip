<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    public function __construct(
        public $head = null,
        public $body = null
    )
    {
        $this->head = $head;
        $this->body = $body;
    }
    
    public function render(): View|Closure|string
    {
        return view('components.table');
    }
}
