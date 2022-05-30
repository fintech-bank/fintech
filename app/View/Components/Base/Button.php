<?php

namespace App\View\Components\Base;

use Illuminate\View\Component;

class Button extends Component
{
    public $id;
    public $class;
    public $text;
    /**
     * @var string
     */
    public $textIndicator;
    /**
     * @var array
     */
    public $datas;
    /**
     * @var null
     */
    public $other;
    /**
     * @var null
     */
    public $tooltip;

    /**
     * Create a new component instance.
     *
     * @param $class
     * @param $text
     * @param array $datas
     * @param $id
     * @param null $other
     * @param string $textIndicator
     * @param null $tooltip
     */
    public function __construct($class, $text, $datas = [], $id = null, $other = null, $textIndicator = "Veuillez Patienter...", $tooltip = null)
    {
        //
        $this->id = $id;
        $this->class = $class;
        $this->text = $text;
        $this->textIndicator = $textIndicator;
        $this->datas = $datas;
        $this->other = $other;
        $this->tooltip = $tooltip;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.base.button');
    }
}
