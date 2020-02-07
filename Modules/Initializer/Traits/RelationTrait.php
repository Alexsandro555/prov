<?php
/**
 * Created by PhpStorm.
 * User: alexsandro
 * Updated Date: 23.10.19 14:49
 * Date: 05.06.18
 * Time: 10:09
 */

namespace Modules\Initializer\Traits;

use Carbon\Carbon;
use ReflectionClass;
use ReflectionMethod;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Relations\Relation;
use Whoops\Exception\ErrorException;

trait RelationTrait
{
  public function getRelations()
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

            $ownerKey = null;
            if ((new ReflectionClass($return))->hasMethod('getOwnerKey'))
              $ownerKey = $return->getOwnerKey();
            else
            {
              $segments = explode('.', $return->getQualifiedParentKeyName());
              $ownerKey = $segments[count($segments) - 1];
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
}