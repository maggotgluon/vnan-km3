<?php

namespace App\Mail;

use App\Models\TrainingRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $requeser,$instructor,$subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(private $request)
    {
        $this->request = TrainingRequest::firstWhere('req_code',$request);
        
        $this->requeser = User::find($this->request->user_id);
        $this->instructor = User::find($this->request->info->meta_value['instructor']);
        $this->subject = $this->request->info->meta_value;
        // dd($this->instructor);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address('training@vananava.com', 'KM Intranet [training]'),
            subject: 'KM Intranet - Training notify '.$this->request->req_obj.' training [code : '.$this->request->req_code.']',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mail.testmail',
            with: ['request' => $this->request],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
