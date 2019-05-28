<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Initializer\Traits\DefaultTrait;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Product\Imports\ProductImport;

/*use Illuminate\Support\Facades\Storage;
use Modules\Files\Classes\ImageHandler;
use Modules\Files\Entities\TypeFile;
use Illuminate\Http\UploadedFile;
use Modules\Files\Entities\File;*/

class ProductController extends Controller
{
  Use ControllerTrait, DefaultTrait;

  public $model;

  public function __construct()
  {
    $this->model = new Product;
  }

  public function specialProducts() {
    return Product::with(['files', 'lineProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function($query) {
      $query->doesntHave('figure');
    }])->where('active',1)->where('special', 1)->get();
  }

  public function import(Request $request)
  {
    if($request->hasFile('file')) {
      Excel::import(new ProductImport, $request->file('file'));
      /*$products = Product::all();
      foreach($products as $product) {
        $fileNames = Storage::files('/public/source');
        $typeFile = TypeFile::where('name', 'image-product')->firstOrFail();
        foreach($fileNames as $fileName) {
          $file = new UploadedFile(storage_path('app/'.$fileName), basename($fileName));
          $imageHandler = new ImageHandler();
          $model = new File;
          $model->fileable_id = $product->id;
          $model->fileable_type = Product::class;
          $model->original_name = basename($fileName);
          $model->type_file_id = $typeFile->id;
          $model->config = $imageHandler->handling($file, $typeFile->config);
          $model->save();
        }
      }*/
      return [];
    }
  }
}
