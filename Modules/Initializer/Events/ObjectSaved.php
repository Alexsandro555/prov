<?php
  namespace Modules\Initializer\Events;

  use Illuminate\Broadcasting\Channel;
  use Illuminate\Queue\SerializesModels;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Broadcasting\InteractsWithSockets;
  use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

  class ObjectSaved implements ShouldBroadcastNow
  {
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance
     *
     * @return void
     */
    public $object;
    public $module;
    public $variable;
    public $key;

    public function __construct(Model $object)
    {
      $relations = $object->getRelations();
      foreach ($relations as $key => $value) {
        $object->unsetRelation($key);
      }
      $this->object=$object;
      $this->module=$object->getTable();
      $this->variable='items';
      $this->key=$object->getKeyName();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
      return ['core'];
    }
  }