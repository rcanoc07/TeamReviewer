<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Tarjetagrupo extends Component
{
    public $grupo;
    public $botonver = false;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($grupo, $botonver = false)
    {
        //
        $this->grupo = $grupo;
        $this->botonver = $botonver;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tarjetagrupo');
    }
}
