<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Button extends Component
{
    public $class;
    public $text;
    /**
     * @var string
     */
    public $textProgress;

    /**
     * Create a new component instance.
     *
     * @param $class
     * @param $text
     * @param string $textProgress
     */
    public function __construct($class = "btn-bank", $text = "Valider", $textProgress = "Veuillez patientez...")
    {
        //
        $this->class = $class;
        $this->text = $text;
        $this->textProgress = $textProgress;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.button');
    }
}
