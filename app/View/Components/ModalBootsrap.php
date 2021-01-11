<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalBootsrap extends Component
{
    public $modalID;
    public $modalTitle;
    public $denyText;
    public $confirmText;
    public $formId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($modalID, $modalTitle, $denyText, $confirmText, $formId)
    {
        $this->modalID = $modalID;
        $this->modalTitle = $modalTitle;
        $this->denyText = $denyText;
        $this->confirmText = $confirmText;
        $this->formId = $formId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.modal-bootsrap');
    }
}
