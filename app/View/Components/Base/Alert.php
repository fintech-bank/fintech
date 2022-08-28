<?php

namespace App\View\Components\Base;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type;

    public $color;

    public $icon;

    public $title;

    public $content;

    /**
     * @var null
     */
    public $buttons;
    /**
     * @var null
     */
    public mixed $class;
    /**
     * @var null
     */
    public mixed $id;

    /**
     * Create a new component instance.
     *
     * @param $type
     * @param $color
     * @param $icon
     * @param $title
     * @param $content
     * @param  null  $buttons
     */
    public function __construct($type, $color, $icon, $title, $content, $buttons = null, $class = null, $id = null)
    {
        //
        $this->type = $type;
        $this->color = $color;
        $this->icon = $icon;
        $this->title = $title;
        $this->content = $content;
        $this->buttons = $buttons;
        $this->class = $class;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.base.alert');
    }
}
