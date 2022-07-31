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
     * @var null
     */
    public $text;

    /**
     * @var null
     */
    public $class;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param $symbol
     * @param $placement
     * @param $label
     * @param  null  $value
     * @param  bool  $required
     * @param  null  $placeholder
     * @param  null  $text
     * @param  null  $class
     */
    public function __construct($name, $symbol, $placement, $label = null, $value = null, $required = false, $placeholder = null, $text = null, $class = null)
    {
        //
        $this->name = $name;
        $this->label = $label;
        $this->symbol = $symbol;
        $this->value = $value;
        $this->required = $required;
        $this->placement = $placement;
        $this->placeholder = $placeholder;
        $this->text = $text;
        $this->class = $class;
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
