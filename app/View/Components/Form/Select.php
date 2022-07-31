<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Select extends Component
{
    public $name;

    public $datas;

    public $label;

    /**
     * @var null
     */
    public $placeholder;

    /**
     * @var bool
     */
    public $required;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param $datas
     * @param $label
     * @param  null  $placeholder
     * @param  bool  $required
     */
    public function __construct($name, $datas, $label, $placeholder = null, $required = true)
    {
        //
        $this->name = $name;
        $this->datas = $datas;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.select');
    }
}
