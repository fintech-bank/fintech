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

    public string $class;

    /**
     * Create a new component instance.
     *
     * @param $title
     * @param  int  $size
     * @param  string  $color
     * @param  string  $sizeText
     * @param  string  $class
     */
    public function __construct($title, $size = 8, $color = 'primary', $sizeText = 'fs-2tx', $class = 'w-250px mt-5 mb-5')
    {
        //
        $this->title = $title;
        $this->size = $size;
        $this->color = $color;
        $this->sizeText = $sizeText;
        $this->class = $class;
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
