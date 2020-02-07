<?php

namespace Modules\Initializer\Traits;
use Modules\Initializer\Observers\CoreObserver;
use Illuminate\Support\Facades\Cache;
use ReflectionClass;
use ReflectionMethod;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Carbon;

trait CoreTrait
{
  static public $upstream = true;
  static public $upstreamWebSocket = true;
  protected $oldDirty;

  public function setOldDirty()
  {
    $this->oldDirty = $this->getDirty();
  }

  public function getOldDirty()
  {
    return $this->oldDirty;
  }

  public static function unsetUpStream()
  {
    static::$upstream = false;
  }

  public static function unsetUpStreamWebSocket()
  {
    static::$upstreamWebSocket = false;
  }

  protected static function bootCoreTrait()
  {
    static::observe(new CoreObserver);
  }

  public static function load_all()
  {
    $model = new static;
    if (property_exists(get_class($model), "load_all")) {
      return self::$load_all;
    }
    return false;
  }

  public function relationships()
  {
    $model = new static;
    $cacheName = 'relationships_'.$model->getTable();
    if (Cache::has($cacheName)) {
      return Cache::get($cacheName);
    }
    else {
      $traitMethodsNames = [];
      foreach((new \ReflectionClass($model))->getTraits() as $name => $trait) {
        $traitMethods = $trait->getMethods();
        foreach ($traitMethods as $traitMethod) {
          $traitMethodsNames[] = $traitMethod->getName();
        }
      }

      $relationships = [];

      $methods = (new ReflectionClass($model))->getMethods(ReflectionMethod::IS_PUBLIC);
      $modelName = get_class($model);
      $currentMethod = collect(explode('::', __METHOD__))->last();
      $methods = collect($methods)->filter(function($method) use ($modelName, $traitMethodsNames, $currentMethod) {
        $methodName = $method->getName();

        if (!in_array($methodName, $traitMethodsNames)  // Метод не должен быть в трейте
          && strpos($methodName, '__') !== 0    // Метод не должен быть магическим начинаться с __
          && $method->class === $modelName             // It must be in the self scope and not inherited
          && !$method->isStatic()                      // It must be in the this scope and not static
          && $methodName != $currentMethod             // It must not be an override of this one
        ) {
          return true;
        } else return false;
      });

      foreach ($methods as $method) {
        if ($method->class != get_class($model) ||
          !empty($method->getParameters()) ||
          $method->getName() == __FUNCTION__ ) {
          continue;
        }
        try {
          $return = $method->invoke($model);

          if($return instanceof Relation && ((new ReflectionClass($return))->getShortName() == 'BelongsTo' || (new ReflectionClass($return))->getShortName() == 'HasMany')) {

              $ownerKey = null;
              if ((new ReflectionClass($return))->hasMethod('getOwnerKeyName'))
                $ownerKey = $return->getOwnerKeyName();
              else {
                if ((new ReflectionClass($return))->hasMethod('getQualifiedOwnerKeyName')) {
                  $segments = explode('.', $return->getQualifiedOwnerKeyName());
                  $ownerKey = $segments[count($segments) - 1];
                }
              }


              $relationships[$method->getName()] = [
                'type' => (new ReflectionClass($return))->getShortName(),
                'table' => $return->getRelated()->getTable(),
                'model' => (new ReflectionClass($return->getRelated()))->getName(),
                'foreignKey' => (new ReflectionClass($return))->hasMethod('getForeignKey')
                  ? $return->getForeignKey()
                  : $return->getForeignKeyName(),
                'ownerKey' => $ownerKey,
              ];
          }
        }
        catch (ErrorException $e) {}
      }
      Cache::put($cacheName, $relationships, Carbon::now()->addDays(1));
      return $relationships;
    }
  }

  /*public function relationships()
  {
    $model = new static;
    $cacheName = 'relationships_'.$model->getTable();
    if (Cache::has($cacheName)) {
      return Cache::get($cacheName);
    }
    else {
      $traitMethodsNames = [];
      foreach((new \ReflectionClass($model))->getTraits() as $name => $trait) {
        $traitMethods = $trait->getMethods();
        foreach ($traitMethods as $traitMethod) {
          $traitMethodsNames[] = $traitMethod->getName();
        }
      }

      $relationships = [];

      $methods = (new ReflectionClass($model))->getMethods(ReflectionMethod::IS_PUBLIC);
      $modelName = get_class($model);
      $currentMethod = collect(explode('::', __METHOD__))->last();
      $methods = collect($methods)->filter(function($method) use ($modelName, $traitMethodsNames, $currentMethod) {
        $methodName = $method->getName();

        if (!in_array($methodName, $traitMethodsNames)  // Метод не должен быть в трейте
          && strpos($methodName, '__') !== 0    // Метод не должен быть магическим начинаться с __
          && $method->class === $modelName             // It must be in the self scope and not inherited
          && !$method->isStatic()                      // It must be in the this scope and not static
          && $methodName != $currentMethod             // It must not be an override of this one
        ) {
          return true;
        } else return false;
      });

      foreach ($methods as $method) {
        if ($method->class != get_class($model) ||
          !empty($method->getParameters()) ||
          $method->getName() == __FUNCTION__ ) {
          continue;
        }
        try {
          $return = $method->invoke($model);

          if($return instanceof Relation) {

            $relationships[$method->getName()]['type'] = (new ReflectionClass($return))->getShortName();
            $relationships[$method->getName()]['table'] =  $return->getRelated()->getTable();
            $relationships[$method->getName()]['model'] = (new ReflectionClass($return->getRelated()))->getName();
            if ( (new ReflectionClass($return))->getShortName() == 'BelongsTo') {

              $related = \DB::select(DB::raw("SELECT k.column_name FROM information_schema.table_constraints t JOIN information_schema.key_column_usage k USING(constraint_name, table_schema, table_name) WHERE t.constraint_type='FOREIGN KEY' AND t.table_schema=schema() AND t.table_name='" . $model->getTable() . "' AND k.referenced_table_name='". $return->getRelated()->getTable() ."'"));
              $nameRelatedTable = $return->getRelated()->getTable();
              $foreignKey = $related?$related[0]->column_name:substr($nameRelatedTable,0,strlen($nameRelatedTable)-1).'_id';

              $ownerKey = null;
              if ((new ReflectionClass($return))->hasMethod('getOwnerKey'))
                $ownerKey = $return->getOwnerKey();
              else
              {
                $segments = explode('.', $return->getQualifiedParentKeyName());
                $ownerKey = $segments[count($segments) - 1];
              }

              $relationships[$method->getName()]['foreignKey'] = $foreignKey;
              $relationships[$method->getName()]['ownerKey'] = $ownerKey;
            }
          }
        }
        catch (ErrorException $e) {}
      }
      Cache::put($cacheName, $relationships, Carbon::now()->addDays(1));
      return $relationships;
    }
  }*/
}