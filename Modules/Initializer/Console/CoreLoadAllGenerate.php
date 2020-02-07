<?php

namespace Modules\Initializer\Console;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Str;

class CoreLoadAllGenerate extends Command
{
  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'core:load-all-generate';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Перезагрузить все данные в load_all параметр.';
  protected $models = [];

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }


  public function handle()
  {
    if (is_null($this->option('model'))) {
      $path=base_path().'/Modules';
      $allFiles = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
      $phpFiles = new \RegexIterator($allFiles, '/\.php$/');
      $model_reflection=new \ReflectionClass('Illuminate\Database\Eloquent\Model');
      foreach ($phpFiles as $phpFile) {
        preg_match("#^(.*?)/Modules/(.*?)/Entities#i",$phpFile->getRealPath(),$matches);
        if (count($matches)==0) {continue;}
        $model=str_replace(base_path(),"",$phpFile->getRealPath());
        $model=str_replace(".php","",$model);
        $model=str_replace("/","\\",$model);
        $class = new \ReflectionClass($model);
        if ($class->isSubclassOf('Illuminate\Database\Eloquent\Model')) {
          if (in_array('Modules\Initializer\Traits\CoreTrait',class_uses($model)))
          {
            if ($model::load_all()) {
              $obj=new \StdClass;
              $obj->model=$model;
              $obj->path=$phpFile->getRealPath();;
              $this->models[]=$obj;
            }
          }
        }

      }
    }
    else {
      $obj=new \StdClass;
      $obj->model=$this->option('model');
      $o=new \ReflectionClass($this->option('model'));
      $obj->path=$o->getFileName();;
      $this->models[]=$obj;
    }

    foreach ($this->models as $value) {
      $module_dir=dirname($value->path,2);
      $str=$value->model;
      $class=new \ReflectionClass($str);
      $class_name=$class->getShortName();
      $class_dir=Str::snake($class_name);
      if (is_dir($module_dir.'/Resources/assets/js/vuex/'.Str::plural($class_dir))) {
        $m=new $value->model;

        file_put_contents($module_dir.'/Resources/assets/js/vuex/'.Str::plural($class_dir).'/items.js','export default '.$m::all()->toJson());

        if(method_exists($m, 'getColumns')) {
          file_put_contents($module_dir.'/Resources/assets/js/vuex/'.Str::plural($class_dir).'/fields.js','export default '.json_encode($m->getColumns()));
        }

        if(method_exists($m, 'getRules')) {
          file_put_contents($module_dir.'/Resources/assets/js/vuex/'.Str::plural($class_dir).'/rules.js','export default '.json_encode($m->getRules()));
        }
      }
    }
  }

  /**
   * Get the console command arguments.
   *
   * @return array
   */
  protected function getArguments()
  {
    return [
      //['example', InputArgument::REQUIRED, 'An example argument.'],
    ];
  }

  /**
   * Get the console command options.
   *
   * @return array
   */
  protected function getOptions()
  {
    return [
      ['model', null, InputOption::VALUE_OPTIONAL, 'Класс модели', null],
    ];
  }
}
