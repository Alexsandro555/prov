<?php

namespace Modules\Initializer\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FieldUniqueTrueBoolean
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
  }

  /**
   * matched - поля по которым идет проверка совпадения
   * unmatched - поля которые позволят исключить обновляему запись (как правило id)
   * field -  поле по которому идет проверка
   * object - объект модели
   */
  public function handle($event)
  {
    if($event->object->{$event->field} == true) {
      $object = $event->object;
      $model = app()->make(get_class($object));
      foreach($event->matched as $key) {
        $model = $model->where($key,'=', $object->{$key});
      }
      foreach($event->unmatched as $key) {
        $model = $model->where($key, '!=', $object->{$key});
      }
      $models = $model->where($event->field, '=', true)->get();
      $models->each(function($item) use ($event) {
        $item->{$event->field} = false;
        $item->save();
      });
    }
  }
}