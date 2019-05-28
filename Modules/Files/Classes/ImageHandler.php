<?php

namespace Modules\Files\Classes;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class ImageHandler extends AbstractImageManipulation
{
  public function __construct()
  {
    parent::__construct();
  }

  public function handling($file, $config)
  {
    // Получаем оригинальное название файла
    $original = $file->getClientOriginalName();
    // сохраняем оригинальны файл
    $fileName = $this->getAllowedFilename($original);
    Storage::putFileAs('/public/', $file, $fileName);

    $fileCollect = collect();

    $collection = collect();
    $collection->put('filename', $fileName);
    $collection->put('size', $file->getClientSize());
    $fileCollect->put('original ', $collection);
    //$collection->put('width', $file->width());
    //$collection->put('height', $file->height());

    // если необходим resize выполняем его
    if (isset($config['resize'])) {
      foreach ($config['resize'] as $type) {
        $image = isset($type["absolute"]) && $type["absolute"] ? $this->resizeAbsolute($file, $type["width"], $type["height"]) : $this->resizeRelative($file, $type["width"], $type["height"]);
        $fileName = $this->getAllowedFilename($original);
        $image->save(storage_path('/app/public/').$fileName);
        $collection = collect();
        $collection->put('filename', $fileName);
        $collection->put('size', $this->size($image));
        $collection->put('width', $type["width"]);
        $collection->put('height', $type["height"]);
        $collection->put('resize', $type);
        $fileCollect->put($type['name'], $collection);
      }
    }
    $result = collect();
    $result->put('files',$fileCollect);
    return $result;
  }
}