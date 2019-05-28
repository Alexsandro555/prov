<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\ProductCategory;

class ProductCategoryTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    $arrProductCategories = [
      ['title' => 'Линия кормления'],
      ['title' => 'Содержание'],
      ['title' => 'Линия поения'],
      ['title' => 'Микроклимат'],
      ['title' => 'Освещение']
    ];

    foreach ($arrProductCategories as $arrProductCategory) {
      ProductCategory::create(['title' => $arrProductCategory['title']]);
    }
  }
}
