<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class InputDate extends Component
{
    public $name;

    public $type;

    public $label;

    /**
     * @var string
     */
    public $value;

    /**
     * @var bool
     */
    public $required;

    /**
     * @var bool
     */
    public $autofocus;

    /**
     * @var null
     */
    public $placeholder;

    /**
     * @var bool
     */
    public $help;

    /**
     * @var null
     */
    public $helpText;

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
     * @param $type
     * @param  string  $label
     * @param  string  $value
     * @param  bool  $required
     * @param  bool  $autofocus
     * @param  null  $placeholder
     * @param  bool  $help
     * @param  null  $helpText
     * @param  null  $text
     * @param  null  $class
     */
    public function __construct($name, $type, $label = '',
        $value = '', $required = false, $autofocus = false,
        $placeholder = null, $help = false, $helpText = null,
        $text = null, $class = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->label = $label;
        $this->value = $value;
        $this->required = $required;
        $this->autofocus = $autofocus;
        $this->placeholder = $placeholder;
        $this->help = $help;
        $this->helpText = $helpText;
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
        return view('components.form.input-date');
    }
}
