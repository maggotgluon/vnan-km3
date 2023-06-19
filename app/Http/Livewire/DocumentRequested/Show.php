<?php

namespace App\Http\Livewire\DocumentRequested;

use App\Models\DocumentRequest;
use Livewire\Component;

class Show extends Component
{
    private $request;
    public function mount($id){
        $this->request = DocumentRequest::with('info')->where('req_code',$id)->first();
    }
    public function render()
    {
        return view('livewire.document-requested.show',[
            'req'=>$this->request,
            'info'=>$this->request->info->meta_value
        ])->extends('layouts.app');
    }
}
