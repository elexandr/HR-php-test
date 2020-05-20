<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use mysql_xdevapi\Collection;

class OrderCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $products;
    protected $sum;
    public $subject;



    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $products, float $sum, string $subject )
    {
        $this->products = $products;
        $this->sum = $sum;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->view('emails.order-completed-mail', ['products' => $this->products, 'sum' => $this->sum]);
    }
}
