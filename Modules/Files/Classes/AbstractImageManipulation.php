<?php

namespace Modules\Files\Classes;

use Intervention\Image\ImageManager;

abstract class AbstractImageManipulation
{
  protected $manager;

  public function __construct()
  {
    $this->manager = new ImageManager();
  }

  private function sanitize($string, $force_lowercase = true, $anal = false)
  {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
      "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
      "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;

    return ($force_lowercase) ?
      (function_exists('mb_strtolower')) ?
        mb_strtolower($clean, 'UTF-8') :
        strtolower($clean) :
      $clean;
  }

  private function createUniqueFilename($filename, $extension)
  {
    $imageToken = substr(sha1(mt_rand()), 0, 5);
    return $filename . '-' . $imageToken . '.' . $extension;
  }


  protected function getAllowedFilename($original) {
    $pos = strripos($original,'.');
    $originalNameWithoutExt = substr($original, 0, $pos);
    $extension = substr($original,$pos+1,strlen($original)-1);
    $filename = $this->sanitize($originalNameWithoutExt);
    $allowed_filename = $this->createUniqueFilename($filename, $extension);
    return $allowed_filename;
  }

  protected function size($image)
  {
    $image = $this->manager->make($image);
    $size = $image->filesize();
    return $size;
  }

  /**
   * Absolute resize image
   *
   * @param $image
   * @param $width
   * @param $height
   * @return mixed
   */
  protected function resizeAbsolute($image, $width, $height)
  {
    return $this->manager->make($image)->resize($width, $height);
  }

  /**
   * Resize relative image
   *
   * @param $image
   * @param $width
   * @param $height
   * @return mixed
   */
  protected function resizeRelative($image, $width, $height)
  {
    return $this->manager->make($image)->resize($width, $height, function ($constraing) {
      $constraing->aspectRatio();
      $constraing->upsize();
    });
  }
}