<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class SelectAjax extends Component
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
    public $url;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param $label
     * @param $url
     * @param null $placeholder
     * @param bool $required
     */
    public function __construct($name, $label,$url, $placeholder = null, $required = true)
    {
        //
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.select-ajax');
    }
}
