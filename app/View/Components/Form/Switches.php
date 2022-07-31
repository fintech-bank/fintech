<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Switches extends Component
{
    public $name;

    public $label;

    public $value;

    public $check;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param $label
     * @param $value
     * @param  null  $check
     */
    public function __construct($name, $label, $value, $check = null)
    {
        //
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->check = $check;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.switch');
    }
}
