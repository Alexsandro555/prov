<?php

namespace Modules\Callback\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Callback\Models\Callback;

class CallbackShipped extends Mailable
{
  use Queueable, SerializesModels;

  public $callback;

  /**
   * CallbackShopped constructor.
   * @param Callback $callback
   */
  public function __construct(Callback $callback)
  {
    $this->callback = $callback;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->from('anna@oooleader.ru')->view('callback::emails.callback-shipped')->with([
      'callback' => $this->callback
    ]);
  }
}
