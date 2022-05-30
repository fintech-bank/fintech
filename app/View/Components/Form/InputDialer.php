<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class InputDialer extends Component
{
    public $name;
    public $label;
    public $min;
    public $max;
    public $step;
    public $value;
    /**
     * @var null
     */
    public $prefix;
    /**
     * @var bool
     */
    public $required;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param $label
     * @param $min
     * @param $max
     * @param $step
     * @param $value
     * @param null $prefix
     * @param bool $required
     */
    public function __construct($name, $label, $min, $max, $step, $value, $prefix = null, $required = false)
    {
        //
        $this->name = $name;
        $this->label = $label;
        $this->min = $min;
        $this->max = $max;
        $this->step = $step;
        $this->value = $value;
        $this->prefix = $prefix;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input-dialer');
    }
}
