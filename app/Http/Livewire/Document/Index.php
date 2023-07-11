<?php

namespace App\Http\Livewire\Document;

use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Unique;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    private $docs;
    public $search,$filter_status,$filter_objective;
    public function mount(){
        
        $schdule = Document::where('status',2)->get();
        if($schdule){
            $docs = Document::where('status',1)->get();
            foreach ($schdule as $key => $doc) {
                if($doc->effective<=now() && $doc->status->value ==2){
                    // dd($doc,$doc->effective<=now()&& $doc->status ==2,$doc->status);
                    // search docs for status 1 change to 0
    
                    $current = $docs->where('doc_code',$doc->doc_code)->first();
                    if($current){
                        $current->status = 0;
                        $current->save();
                    }
                    // dd($doc,$docs,$current);
                    // update self to 1
                    $doc->status=1;
                    // save
                    // dd($current,$doc);
                    $doc->save();
                }
            }
        }
    }
    public function render()
    {
        $this->docs = Document::with('ref');

        // dd($this->docs->get());
            // ->latest('doc_code')->first();
        // ->paginate(10);
        // $a = Document::latest()->dump();

        return view('livewire.document.index',[
            'documents'=>$this->docs
            // ->whereDate('effective','<=',now())
            ->where('status',1)
            ->whereNot('doc_type','record')
            ->orderBy('effective','desc')
            ->paginate(10),
            'user'=>User::all()
        ])->extends('layouts.app');
    }
}
