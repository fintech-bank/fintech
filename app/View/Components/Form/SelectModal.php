<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class SelectModal extends Component
{
    public $name;

    public $parent;

    public $datas;

    /**
     * @var null
     */
    public $placeholder;

    /**
     * @var bool
     */
    public $required;

    public $label;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param $parent
     * @param $datas
     * @param $label
     * @param  null  $placeholder
     * @param  bool  $required
     */
    public function __construct($name, $parent, $datas, $label, $placeholder = null, $required = true)
    {
        //
        $this->name = $name;
        $this->parent = $parent;
        $this->datas = $datas;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.select-modal');
    }
}
