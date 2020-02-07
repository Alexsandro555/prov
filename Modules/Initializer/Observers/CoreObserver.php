<?php

namespace Modules\Initializer\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Modules\Initializer\Events\ObjectSaved;
use Illuminate\Support\Facades\Artisan;

class CoreObserver
{
  public $attributes;

  public $relations;

  public function created(Model $model)
  {
    if ($model::load_all() === true) {
      Artisan::call('core:load-all-generate', ['--model' => get_class($model)]);
    }
  }

  public function deleted(Model $model)
  {
    $attributes = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
    $relations = $model->relationships();
    foreach ($relations as $method => $relation) {
      if ($relation['type'] == 'BelongsTo') {
        if ($model->{$method}()->get()->count() > 0) {
          $model->{$method}->save();
        }
      }
    }

    if ($model::load_all() === true) {
      Artisan::call('core:load-all-generate', ['--model' => get_class($model)]);
    }
  }

  public function saving(Model $model)
  {
    $model->setOldDirty();
    $attributes = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
    if (in_array("computed", $attributes)) {
      if (is_null($model->computed) || (count($model->computed) == 0)) {
        $model->computed = [];
        $model->computed = $model->computed->put("core", true);
      }
      $relations = $model->relationships();
      foreach ($relations as $method => $relation) {
        if (($relation['type'] == 'HasMany') || ($relation['type'] == 'HasManyThrought') || ($relation['type'] == 'HasOneDeep') || ($relation['type'] == 'HasManyDeep') || ($relation['type'] == 'MorphMany')) {
          $model->computed = $model->computed->put($method . '_number', $model->{$method}->count());
        }
      }
      if (count($model->computed->keys()->all()) > 1) {
        if ($model->computed->has('core')) {
          $model->computed = $model->computed->forget("core");
        }
      }
    }

    foreach ($model->toArray() as $name => $value) {
      if (empty($value)) {
        if (!isset($model->{$name}) && in_array($name, $attributes)) $model->{$name} = null;
      }
    }
  }

  public function saved(Model $model)
  {
    if ($model::$upstreamWebSocket === true) Event::dispatch(new ObjectSaved($model));

    $relations = $model->relationships();
    if ($model::$upstream === true) {
      $old_dirty = array_keys($model->getOldDirty());
      foreach ($relations as $method => $relation) {
        if (($relation['type'] == 'BelongsTo') || ($relation['type'] == 'MorphTo')) {
          if (in_array($relation['foreignKey'], $old_dirty)) {
            if ($model->{$method}()->get()->count() > 0) {
              if (is_object($model->{$method})) $model->{$method}->save();
            }
          }
        }
      }
    }

    if ($model::load_all() === true) {
      if (count(array_keys($model->getOldDirty())) > 0) {
        Artisan::call('core:load-all-generate', ['--model' => get_class($model)]);
      }
    }

  }
}