<?php
namespace Modules\Initializer\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

trait ControllerTrait {

  public $model;

  public function index()
  {
    return [
      'items' => $this->model->all(),
      'rules' => method_exists($this->model, 'getRules')?$this->model->getRules():null,
      'relations' => method_exists($this->model, 'relationships')?$this->model->relationships():null,
      'fields' => method_exists($this->model, 'getColumns')?$this->model->getColumns():null,
      'count' => $this->model->count()
    ];
  }

  public function load(Request $request)
  {
    $values=$request->all();
    $m=$this->model;
    $visible=null;
    $methodanalize=[];
    foreach ($values as $key=>$value) {
      switch ($key) {
        case '_order':
          $fields=explode("|",$value);
          $fields[0]=str_replace(".","->",$fields[0]);
          $m=$m->orderBy($fields[0],(count($fields)>1)?$fields[1]:'asc');
          break;
        case '_take':
          $m=$m->take(intval($value));
          break;
        case '_function':
          $methodanalize=explode("|",$value);
          break;
        case '_visible':
          $visible=$value;
          break;
        default:
          if (is_array($value)) {
            $m=$m->whereIn($key,(array) $value);} else {
            if (preg_match("#->#i",$key)) {
              // if ($value==1) {$value=true;}
            }
            // Для передачи данных по выборке необходимо добавить в ключ управляющие выборкой символы (>,=,<= и т.д)
            $fields=explode("|",$key);
            if (count($fields)==1) {$fields[1]='=';}
            switch ($fields[1]) {
              case 'null':
                $m=$m->whereNull($fields[0]);
                break;
              case 'not_null':
                $m=$m->whereNotNull($fields[0]);
                break;
              default:
                $m=$m->where($fields[0],$fields[1],$value);
            }
          }
      }
    }
    $collection=$m->get();
    if (!is_null($visible)) {
      $collection=$collection->each(function ($item) use ($visible) {
        $item->makeVisible($visible);
      });
    }
    if (count($methodanalize)>0) {
      $collection=$collection->{$methodanalize[0]}($methodanalize[1]);
    }

    return [
      'items' => $collection,
      'rules' => method_exists($this->model, 'getRules')?$this->model->getRules():null,
      'relations' => method_exists($this->model, 'relationships')?$this->model->relationships():null,
      'fields' => method_exists($this->model, 'getColumns')?$this->model->getColumns():null,
      'count' => $this->model->count()
    ];
  }

  public function save(Request $request)
  {
    $multidim=false;
    $attributes = Schema::getColumnListing($this->model->getTable());
    foreach ($request->all() as $key=>$value) {
      if ($key===0) $multidim=true;break;
    }
    if (!$multidim) {
      $this->model=$this->model->firstOrNew([$this->model->getKeyName() =>$request[$this->model->getKeyName()]]);
      $this->model->fill($request->all());
      $this->model->save();
      foreach ($attributes as $value) {
        if (empty($this->model->{$value})) { if (!isset($this->model->{$value})) $this->model->{$value}=null;}
      }
      $relations = $this->model->relationships();
      foreach($relations as $key => $value) {
        $this->model->unsetRelation($key);
      }
      return $this->model;
    } else {
      $arrF = [];
      foreach ($request->all() as $value) {
        $f=$this->model->firstOrNew([$this->model->getKeyName() => $value[$this->model->getKeyName()]]);
        $f->fill($value);
        $f->save();
        foreach($attributes as $value) {
          if (empty($f->{$value})) { if (!isset($f->{$value})) $f->{$value}=null;}
        }
        $relations = $f->relationships();
        foreach($relations as $key => $value) {
          $f->unsetRelation($key);
        }
        array_push($arrF, $f);
      }
      return $arrF;
    }
    return $f;
  }

  public function toggle(Request $request)
  {
    $this->model=$this->model->firstOrNew([$this->model->getKeyName() =>$request[$this->model->getKeyName()]]);
    $this->model->{$request->relation}()->toggle($request->toggled_ids);
    return $this->model->{$request->relation};
  }

  public function search(Request $request)
  {
    $search=$request->search;
    if (strlen($search)<2) {return [];}
    $table=$this->model->getTable();
    $results=DB::select('describe '.$table);
    $fields=[];
    foreach ($results as $key)
    {
      if (preg_match('#varchar#i',$key->Type))
      {
        $fields[]=$key->Field;
      }
      if (preg_match('#text#i',$key->Type))
      {
        $fields[]=$key->Field;
      }
    }
    $m=$this->model;
    if (count($fields)>0)
    {
      foreach($fields as $key)
      {
        $m=$m->orWhere($key,'like','%'.$search.'%');
      }
      $m=$m->take(100);
      return $m->get();
    } else {return [];}
  }

  public function delete(Request $request)
  {
    $k=$this->model->find($request->id);
    $k->delete();
    return $k;
  }
}

