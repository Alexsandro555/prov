<?php
/**
 * Created by PhpStorm.
 * User: alexsandro
 * Date: 18.04.18
 * Time: 14:20
 */

namespace Modules\Files\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Modules\Files\Entities\File;

class UploadService
{
  // путь для сохраняемых файлов
  protected $path = "app/public/";
  protected $manager;
  protected $typeFile;
  protected $request;
  protected $normalizedFilename;
  protected $file;
  protected $image;

  public function __construct()
  {
    $this->manager = new ImageManager();
  }

  public function upload($request, $image) {
    $this->request = $request;
    $this->image = $image;

    // массив сохраненных файлов
    $arr = [];
    $config = $request->typeFile->config;
    if($config->has('resize')) {
      foreach ($config['resize'] as $type) {
        $allowedFilename = $this->createUniqueFilename();
        if(isset($type["absolute"])) {
          if($type["absolute"]) {
            $result = $this->resizeAbsolute($allowedFilename, $type['width'], $type['height']);
          } else {
            $result = $this->resizeRelative($allowedFilename, $type['width'], $type['height']);
          }

          $file = collect();
          $file->put('filename',$allowedFilename);
          $file->put('size',$this->size($result));
          $file->put('width',$result->width());
          $file->put('height',$result->height());
          foreach ($config->get('resize') as $item) {
            if($item["name"] === $type['name']) {
              $file->put('resize',$item);
            }
          }
          $arr[$type['name']] = $file;
        }
      }
      $fileCollect = collect();
      $fileCollect->put('files',$arr);
    }

    $this->file = new File;
    $this->file->fileable_id = $request->fileable_id;
    if ($request->has('alt')) {
      $this->file->alt = $request->alt;
    }
    $this->file->fileable_type = $request->fileable_type;
    $this->file->type_file_id = $request->typeFile->id;
    $this->file->config = $fileCollect;
    /// сохранение оригинала
    $allowedFilename = $this->createUniqueFilename();
    Storage::putFileAs('public',$this->image,$allowedFilename);
    $this->file->original_name = $allowedFilename;
    $this->file->save();
    return $this->file;
  }

  protected function resizeAbsolute($filename, $width, $height)
  {
    return $this->manager->make($this->image)->resize($width,$height)->save(storage_path($this->path) . $filename );
  }

  protected function resizeRelative($filename, $width, $height)
  {
    $image = $this->manager->make($this->image);
    $image = $image->resize($width,$height,function($constraing) {
      $constraing->aspectRatio();
      $constraing->upsize();
    })->save(storage_path($this->path) . $filename);
    return $image;
  }

  private function size($file)
  {
    $image = $this->manager->make($file);
    return $image->filesize();
  }

  private function sanitize($string, $force_lowercase = true, $anal = false)
  {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
      "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
      "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;

    return ($force_lowercase) ?
      (function_exists('mb_strtolower')) ?
        mb_strtolower($clean, 'UTF-8') :
        strtolower($clean) :
      $clean;
  }

  private function createUniqueFilename()
  {
    // Generate token for image
    $imageToken = substr(sha1(mt_rand()), 0, 5);
    $originalNameWithoutExt = substr($this->image->getClientOriginalName(), 0, strlen($this->image->getClientOriginalName()) - strlen($this->image->getClientOriginalExtension()) - 1);
    return  $this->sanitize($originalNameWithoutExt). '-' . $imageToken . '.' . $this->image->getClientOriginalExtension();
  }
}