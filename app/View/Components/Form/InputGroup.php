<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class InputGroup extends Component
{
    public $name;
    public $label;
    public $symbol;
    /**
     * @var null
     */
    public $value;
    /**
     * @var bool
     */
    public $required;
    public $placement;
    /**
     * @var null
     */
    public $placeholder;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param $label
     * @param $symbol
     * @param $placement
     * @param null $value
     * @param bool $required
     * @param null $placeholder
     */
    public function __construct($name, $label, $symbol, $placement,  $value = null, $required = false, $placeholder = null)
    {
        //
        $this->name = $name;
        $this->label = $label;
        $this->symbol = $symbol;
        $this->value = $value;
        $this->required = $required;
        $this->placement = $placement;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input-group');
    }
}
