<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{    
    public function __construct(
        public $label = null,
        public $type = 'text',
        public $wire = null,
        public $name = null,
        public $id = null,
        public $value = null,
        public $min = 0,
        public $max = 100,
        public $step = null,
        public $class = null,
        public $cols = null,
        public $rows = '8',
        public $placeholder = null,
        public $description = null,
        public $options = null,
        public $field = null,
        public $autocomplete = 'off',
        public $required = false,
        public $readonly = false,
        public $disabled = false,
        public $autofocus = false,
    )
    {
        $this->label = $label;
        $this->type = $type;
        $this->wire = $wire;
        
        if (!$name && !$wire) {
            $this->name = $this->type;
        } else {
            $this->name = $name ? $name : $this->wire;
        }
        
        $this->id = $id ? $id : $this->name;
        $this->min = $min;
        $this->max = $max;
        $this->step = $step;
        $this->class = $class;
        $this->cols = $cols;
        $this->rows = $rows;
        $this->placeholder = $placeholder;
        $this->description = $description;
        $this->field = $field;
        $this->autocomplete = $autocomplete;
        $this->required = $required;
        $this->readonly = $readonly;
        $this->disabled = $disabled;
        $this->autofocus = $autofocus;
        $this->options = $options ? json_decode($options, true) : [];
        
        if ($type == 'radio' || $type == 'checkbox' || $type == 'select') {
            $this->value = json_decode($value, true);
        } else {
            $this->value = $value;
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
