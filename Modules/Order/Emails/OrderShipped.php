<?php

namespace Modules\Order\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Order\Entities\Order;

class OrderShipped extends Mailable
{
  use Queueable, SerializesModels;

  public $order;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct(Order $order)
  {
    $this->order = $order;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->from('alexsandro@oooleader.ru')->view('order::emails.order-shipped')->with([
      'number' => $this->order->number,
      'email' => $this->order->user->email,
      'telephone' => $this->order->user->telephone,
      'note' => $this->order->note,
      'products' => $this->order->products
    ]);
  }
}
