<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Radio extends Component
{
    public $name;
    public $value;
    public $for;
    public $label;
    /**
     * @var bool
     */
    public $checked;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param $value
     * @param $for
     * @param $label
     * @param bool $checked
     */
    public function __construct($name, $value, $for, $label, $checked = false)
    {
        //
        $this->name = $name;
        $this->value = $value;
        $this->for = $for;
        $this->label = $label;
        $this->checked = $checked;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.radio');
    }
}
