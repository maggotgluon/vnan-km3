<?php

namespace App\Http\Livewire\Record;

use App\Models\Document;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    private $docs;
    public $search,$filter_status,$filter_objective;
    public function mount(){
        $docs = Document::all();
        foreach ($docs as $key => $doc) {
            if($doc->effective<=now() && $doc->status ==2){
                // search docs for status 1 change to 0
                $current = $docs->Where('status',1)->where('doc_code',$doc->doc_code)->first();
                $current->status = 0;
                // update self to 1
                $doc->status=1;
                // save
                // dd($current,$doc);
                $current->save();
                $doc->save();
            }
        }
    }
    public function render()
    {
        $this->docs = Document::with('ref');
        return view('livewire.record.index',[
            'documents'=>$this->docs
            // ->whereDate('effective','<=',now())
            ->where('status',1)
            ->where('doc_type','record')
            ->orderBy('effective','desc')
            ->paginate(10)
        ])->extends('layouts.app');
    }
}
