<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardImage extends Component
{
    public $link;
    public $imagePath;
    public $description;
    public $title;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($link, $imagePath, $description, $title)
    {
        $this->link = $link;
        $this->imagePath = $imagePath;
        $this->description = $description;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.card-image');
    }
}
