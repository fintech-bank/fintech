<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Textarea extends Component
{
    public $name;

    public $label;

    /**
     * @var bool
     */
    public $required;

    /**
     * @var null
     */
    public $value;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param $label
     * @param  bool  $required
     * @param  null  $value
     */
    public function __construct($name, $label, $required = false, $value = null)
    {
        //
        $this->name = $name;
        $this->label = $label;
        $this->required = $required;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.textarea');
    }
}
