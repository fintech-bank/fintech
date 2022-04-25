<?php

namespace App\View\Components\Base;

use Illuminate\View\Component;

class Underline extends Component
{
    public $title;
    /**
     * @var int
     */
    public $size;
    /**
     * @var string
     */
    public $color;
    /**
     * @var string
     */
    public $sizeText;

    /**
     * Create a new component instance.
     *
     * @param $title
     * @param int $size
     * @param string $color
     * @param string $sizeText
     */
    public function __construct($title, $size = 8, $color = 'primary', $sizeText = 'fs-2tx')
    {
        //
        $this->title = $title;
        $this->size = $size;
        $this->color = $color;
        $this->sizeText = $sizeText;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.base.underline');
    }
}
