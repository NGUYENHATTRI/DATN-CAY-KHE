<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuccessInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $id,$name,$total,$order_date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id,$name,$total,$order_date)
    {
        $this->id = $id;
        $this->name = $name;
        $this->total = $total;
        $this->order_date = $order_date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('client.emails.successinvoice')
            ->with([
                'id' => $this->id,
                'name' => $this->name,
                'total' => $this->total,
                'order_date' => $this->order_date,
            ])->subject('Thanh toán thành công hóa đơn INV'.$this->id .'');
    }
}
