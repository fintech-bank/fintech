<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class SelectOption extends Component
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

    public $key;

    public $value;

    /**
     * @var null
     */
    public $other;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param $datas
     * @param $label
     * @param $key
     * @param $value
     * @param  null  $placeholder
     * @param  bool  $required
     * @param  null  $other
     */
    public function __construct($name, $datas, $label, $key, $value, $placeholder = null, $required = true, $other = null)
    {
        //
        $this->name = $name;
        $this->datas = $datas;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->key = $key;
        $this->value = $value;
        $this->other = $other;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.select-option');
    }
}
