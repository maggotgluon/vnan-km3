<?php

namespace App\Http\Livewire\Document;

use App\Models\Document;
use Livewire\Component;

class Show extends Component
{
    private $code;
    public function mount($id){
        $this->code=$id;
    }
    public function render()
    {

        return view('livewire.document.show',[
            'doc'=>Document::where('doc_code',$this->code)->first()
        ])->extends('layouts.app');
    }
}
