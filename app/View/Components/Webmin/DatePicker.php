<?php

namespace App\View\Components\Webmin;

use Illuminate\View\Component;

class DatePicker extends Component
{
    public $label;
    public $placeholder;
    public $name;
    public $value;
    public $required;
    public $disabled;
    public $imagesize;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $label="",
        $placeholder="",
        $name,
        $value,
        $required="",
        $disabled="false",
        $imagesize=""
    ){
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->imagesize = $imagesize;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.webmin.datepicker');
    }
}
