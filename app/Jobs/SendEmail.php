<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Auth;
use Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        switch ($this->details['email']) {
            case 'acknowledgment':
                $sendTo=Auth::user()->acknowledgment();
                break;
            case 'trainingReviewer':
                $sendTo=Auth::user()->trainingReviewer();
                break;
            case 'trainingApprover':
                $sendTo=Auth::user()->trainingApprover();
                break;
            default:
                $sendTo=Auth::user();
                break;
        }
        if(get_class($sendTo)==="App\Models\User"){
            $to = $sendTo->email;
        }else{
            $to = array();
            foreach ($sendTo as $key => $value) {
                array_push($to, $value->email);
            }
        }
        // dd(get_class($sendTo)==="App\Models\User" ,$to);

        $email = new TestMail($this->details['data']);
        Mail::to($this->details['email'])->send($email);
    
    }
}
