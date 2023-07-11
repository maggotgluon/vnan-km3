<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class PdfViewer extends Component
{
    public $file;
    public function render()
    {
        return view('livewire.components.pdf-viewer');
    }
}
