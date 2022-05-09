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
     * @var null
     */
    public $id;
    /**
     * @var array
     */
    public $dataset;

    /**
     * Create a new component instance.
     *
     * @param string $class
     * @param string $text
     * @param string $textProgress
     * @param null $id
     * @param array $dataset
     */
    public function __construct($class = "btn-bank", $text = "Valider", $textProgress = "Veuillez patientez...", $id = null, $dataset = [])
    {
        //
        $this->class = $class;
        $this->text = $text;
        $this->textProgress = $textProgress;
        $this->id = $id;
        $this->dataset = $dataset;
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
