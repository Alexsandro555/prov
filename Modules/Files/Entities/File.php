<?php
namespace Modules\Files\Entities;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;
use Intervention\Image\Facades\Image;

class File extends Model
{
  protected $guarded = [];


  public function typeFile()
  {
    return $this->belongsTo(TypeFile::class);
  }

  public function figure()
  {
    return $this->hasMany(Figure::class);
  }

  public static function streamMimeType($content)
  {
    $mimeType = finfo_buffer(finfo_open(), $content, FILEINFO_MIME_TYPE);

    return $mimeType;
  }

  public static function streamSize($content)
  {
    $size = strlen($content);

    return $size;
  }

  public static function mimeExtension($mimeType)
  {
    $extension = ExtensionGuesser::getInstance()->guess($mimeType);

    return $extension;
  }

  public static function streamExtension($content)
  {
    $mimeType = $self->streamMimeType($content);
    $extension = $self->streamMimeExtension($mimeType);

    return $extension;
  }

  public static function put($path, $content)
  {
    file_put_contents($path, $content);
  }

  protected $casts = [
    'config' => 'collection',
  ];

  protected static function boot()
  {
      parent::boot(); // TODO: Change the autogenerated stub

      static::deleting(function($file) {
          $full_size_dir = storage_path('app/public/');
          foreach ($file->config as $itemFiles) {
            foreach ($itemFiles as $itemFile) {
              $fileDir = $full_size_dir.$itemFile["filename"];
              unlink($fileDir);
            }
          }
      });
  }
}