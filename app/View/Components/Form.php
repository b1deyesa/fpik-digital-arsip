<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    public $method_name = null;
    
    public function __construct(
        public $id = null,
        public $class = null,
        public $action = null,
        public $method = 'GET',
        public $wire = null,
    )
    {
        $this->id = $id ?? $class;
        $this->class = $class;
        $this->action = $action;
        $this->method = $method;
        $this->wire = $wire;
        
        if ($this->method == 'PUT') {
            $this->method = 'POST';
            $this->method_name = 'PUT';
        } elseif ($this->method == 'DELETE') {
            $this->method = 'POST';
            $this->method_name = 'DELETE';
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form');
    }
}
