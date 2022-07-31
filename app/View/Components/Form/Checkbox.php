<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $name;

    public $label;

    public $value;

    /**
     * @var bool
     */
    public $checked;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param $label
     * @param $value
     * @param  bool  $checked
     */
    public function __construct($name, $label, $value, $checked = false)
    {
        //
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->checked = $checked;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.checkbox');
    }
}
