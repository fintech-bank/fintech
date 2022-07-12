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
     * @var null
     */
    public $function;
    /**
     * @var null
     */
    public $nameFunction;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param $value
     * @param $for
     * @param $label
     * @param bool $checked
     * @param null $function
     * @param null $nameFunction
     */
    public function __construct($name, $value, $for, $label, $checked = false, $function = null, $nameFunction = null)
    {
        //
        $this->name = $name;
        $this->value = $value;
        $this->for = $for;
        $this->label = $label;
        $this->checked = $checked;
        $this->function = $function;
        $this->nameFunction = $nameFunction;
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
