<?php

namespace Modules\Initializer\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ListValueSaved implements ShouldBroadcastNow
{
  use SerializesModels;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public $model;

  public function __construct(Model $model)
  {
    $this->matched=$model->matched;
    $this->unmatched = $model->unmatched?:['id'];
    $this->field=$model->field?:'default';
    $this->object = $model;
  }

  public function broadcastOn()
  {
    return ['Initializer'];
  }
}
