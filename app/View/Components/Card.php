<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $title;
    public $icon;
    public $class;

    public function __construct($title = null, $icon = null, $class = '')
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.card');
    }
}

