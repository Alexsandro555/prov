<?php

namespace Modules\Files\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Files\Entities\Figure;
use Modules\Files\Http\Requests\Base64ImageRequest;
use Modules\Files\Http\Requests\FileRequest;
use Modules\Files\Services\UploadService;
use Modules\Files\Entities\File;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\AttributeValue;
use Modules\Product\Entities\LineProduct;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductCategory;
use Modules\Product\Entities\TypeProduct;
use Modules\Initializer\Traits\ControllerTrait;

class FilesController extends Controller
{
  Use ControllerTrait;

  public $model;

  public function __construct()
  {
    $this->model = new File;
  }

  /**
   * Upload file
   *
   * @param UploadService $uploadService
   * @param FileRequest $request
   * @return array
   * @throws \Exception
   */
  public function store(FileRequest $request, UploadService $uploadService)
  {
    return $uploadService->upload($request, $request->file('file'));
  }

  /**
   * Custom upload file
   *
   * @param UploadService $uploadService
   * @param Base64ImageRequest $request
   * @return array
   * @throws \Exception
   */
  public function customStore(Base64ImageRequest $request, UploadService $uploadService)
  {
    return $uploadService->upload($request, $request->files->get('file'));
  }

  /**
   * Upload file
   *
   * @param UploadService $uploadService
   * @param FileRequest $request
   * @return array
   * @throws \Exception
   */
  public function storeWysiwyg(FileRequest $request, UploadService $uploadService)
  {
    return $uploadService->upload($request, $request->files->get('file'));
    /*$file = $uploadService->upload($request, $request->file('file'));
    $arrFiles = [];
    foreach ($file->config as $files) {
      foreach ($files as $key => $file) {
        if ($key !== 'original') {
          $fileItem['filename'] = $file["filename"];
          $fileItem['width'] = $file["width"];
          $fileItem['height'] = $file["height"];
          $arrFiles[] = $fileItem;
        }
      }
    }
    return ['files' => $arrFiles];*/
  }

  /**
   *  Get Files
   * @param int $id
   * @return \Illuminate\Http\Response:json
   */
  public function getImages(Request $request)
  {
    $files = File::where('fileable_id',$request->id)->where('fileable_type',$request->model)->get();
    return response()->json($files,200);
  }

  /**
   *  Delete Image
   * @param int $id
   * @return \Illuminate\Http\Response:json
   */
  public function deleteFile($id)
  {
    $file = File::find($id);
    if($file) {
      $file->delete();
      return response()->json(['message' => 'Успешно удалено'],200);
    }
    else {
      return response()->json(['message' => 'Не существующий идентефикатор'],422);
    }
  }

  public function productImage($id)
  {
    // TODO: требуется выполнить оптимизацию #1 проблема
    $product = Product::findOrFail($id);
    return File::with('typeFile', 'figure')
              ->where(function ($query) use (&$product) {
                      $query->where('fileable_id', $product->product_category_id)->where('fileable_type', ProductCategory::class);
            })->orWhere(function ($query) use (&$product) {
                      $query->where('fileable_id', $product->type_product_id)->where('fileable_type', TypeProduct::class)->where('type_file_id', 2);
            })->orWhere(function ($query) use (&$product) {
                      $query->where('fileable_id', $product->line_product_id)->where('fileable_type', LineProduct::class)->where('type_file_id', 2);
            })->orWhere(function ($query) use (&$product) {
                      $query->where('fileable_id', $product->id)->where('fileable_type', Product::class)->where('type_file_id', 2);
            })->get();
  }

  public function figure($id, $type = 'medium', $product_id = null)
  {
    $image = File::findOrFail($id);
    $figures = Figure::where('file_id', $id)->where('type', $type)->get();
    $imagePath = storage_path('app/public/'.$image->config['files'][$type]['filename']);
    $extension = pathinfo($imagePath)['extension'];
    $size = filesize($imagePath);
    switch ($extension)
    {
      case "jpg":
        header("Content-Type: image/jpeg");
        $img = imagecreatefromjpeg($imagePath);
        break;
      case "gif":
        header("Content-Type: image/gif");
        $img = imagecreatefromgif($imagePath);
        break;
      case "png":
        header("Content-Type: image/png");
        $img = imagecreatefrompng($imagePath);
        break;
      default:
        break;
    }

    if($img) {
      $orig_width = imagesx($img);
      $orig_height = imagesy($img);

      // какие-то установки цвета - для чего они вообще нужны?
      $index = imagecolorresolve($img, 227, 227, 227);
      imagecolorset($img, $index, 255, 255, 255);
      $index = imagecolorresolve($img, 229, 229, 229);
      imagecolorset($img, $index, 255, 255, 255);

      foreach ($figures as $figure) {
        list($r,$g,$b)=explode("/",$figure->color);
        $color = imagecolorallocatealpha($img, $r, $g, $b, 0);
        putenv('GDFONTPATH=' . $_SERVER["DOCUMENT_ROOT"].'/fonts/msttcorefonts/');
        if($product_id) {
          $attributeValue = AttributeValue::where('attribute_id', $figure->attribute_id)->where('product_id', $product_id)->first();
          $text = $attributeValue?$attributeValue->value:'';
        } else {
          $attribute = Attribute::findOrFail($figure->attribute_id);
          $text = $attribute->title;
        }
        $box = imagettftext($img, 10, $figure->degree,$figure->x, $figure->y,$color, "Arial", $text);
      }
      //header('Content-Length: ' . $size);
      switch ($extension)
      {
        case "jpg":
          return imagejpeg($img);
        case "gif":
          return imagegif($img);
        case "png":
          return imagepng($img);
        default:
          throw new \Exception('Несуществующий формат изображения');
          break;
      }
    }

    // до данной точки не должен доходить никогда
    return abort(404);
  }

  public function createFigure(Request $request)
  {
    $model = new Figure;
    $model->x = $request->x;
    $model->y = $request->y;
    $model->degree = $request->degree;
    $model->attribute_id = $request->attribute_id;
    $model->file_id = $request->file_id;
    $model->color = $request->color['rgba']['r'].'/'.$request->color['rgba']['g'].'/'.$request->color['rgba']['b'];
    $model->type = $request->type;
    $model->save();
  }
}
