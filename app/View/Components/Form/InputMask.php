<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class InputMask extends Component
{
    public $name;

    public $label;

    public $mask;

    /**
     * @var bool
     */
    public $required;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param $label
     * @param $mask
     * @param  bool  $required
     */
    public function __construct($name, $label, $mask, $required = true)
    {
        //
        $this->name = $name;
        $this->label = $label;
        $this->mask = $mask;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input-mask');
    }
}
