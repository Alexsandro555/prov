<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\AttributeListValues;

class AttributeListTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    $arrAttributeLists = [
      ['title' => '5,0', 'sort' => 1, 'attribute_id' => 1],
      ['title' => '7,5', 'sort' => 2, 'attribute_id' => 1],
      ['title' => '10', 'sort' => 3, 'attribute_id' => 1],
      ['title' => '15', 'sort' => 4, 'attribute_id' => 1],
      ['title' => '20', 'sort' => 5, 'attribute_id' => 1],
      ['title' => '25', 'sort' => 6, 'attribute_id' => 1],
      ['title' => '30', 'sort' => 7, 'attribute_id' => 1],
      ['title' => '40', 'sort' => 8, 'attribute_id' => 1],
      ['title' => '50', 'sort' => 9, 'attribute_id' => 1],
      ['title' => '60', 'sort' => 10, 'attribute_id' => 1],
      ['title' => '80', 'sort' => 11, 'attribute_id' => 1],
      ['title' => '100', 'sort' => 12, 'attribute_id' => 1],
      ['title' => '56В14', 'sort' => 1, 'attribute_id' => 13],
      ['title' => '56В5', 'sort' => 2, 'attribute_id' => 13],
      ['title' => '63В5', 'sort' => 3, 'attribute_id' => 13],
      ['title' => '63В14', 'sort' => 4, 'attribute_id' => 13],
      ['title' => '71В5', 'sort' => 5, 'attribute_id' => 13],
      ['title' => '71В14', 'sort' => 6, 'attribute_id' => 13],
      ['title' => '80В5', 'sort' => 7, 'attribute_id' => 13],
      ['title' => '80В14', 'sort' => 8, 'attribute_id' => 13],
      ['title' => '90В5', 'sort' => 9, 'attribute_id' => 13],
      ['title' => '90В14', 'sort' => 10, 'attribute_id' => 13],
      ['title' => '100/112В5', 'sort' => 11, 'attribute_id' => 13],
      ['title' => '100/112В14', 'sort' => 12, 'attribute_id' => 13],
      ['title' => '132В5', 'sort' => 13, 'attribute_id' => 13],
      ['title' => 'односторонний', 'sort' => 1, 'attribute_id' => 14],
      ['title' => 'Е - двухсторонний', 'sort' => 2, 'attribute_id' => 14],
      ['title' => 'без фланца', 'sort' => 1, 'attribute_id' => 15],
      ['title' => 'FA', 'sort' => 2, 'attribute_id' => 15],
      ['title' => 'FB', 'sort' => 3, 'attribute_id' => 15],
      ['title' => 'FC', 'sort' => 4, 'attribute_id' => 15],
      ['title' => 'FD', 'sort' => 5, 'attribute_id' => 15],
      ['title' => 'FE (1/2)', 'sort' => 6, 'attribute_id' => 15],
      ['title' => 'полый выходной вал', 'sort' => 1, 'attribute_id' => 16],
      ['title' => 'AS (1/2): односторонний выходной вал и расположение', 'sort' => 2, 'attribute_id' => 16],
      ['title' => 'AВ: двухсторонний выходной вал', 'sort' => 3, 'attribute_id' => 16],
      ['title' => 'B3', 'sort' => 1, 'attribute_id' => 17],
      ['title' => 'B6', 'sort' => 2, 'attribute_id' => 17],
      ['title' => 'B7', 'sort' => 3, 'attribute_id' => 17],
      ['title' => 'B8', 'sort' => 4, 'attribute_id' => 17],
      ['title' => 'V5', 'sort' => 5, 'attribute_id' => 17],
      ['title' => 'V6', 'sort' => 7, 'attribute_id' => 17],
      ['title' => 'AS1', 'sort' => 8, 'attribute_id' => 17],
      ['title' => 'AS2', 'sort' => 9, 'attribute_id' => 17],
      ['title' => 'BS1', 'sort' => 10, 'attribute_id' => 17],
      ['title' => 'BS2', 'sort' => 11, 'attribute_id' => 17],
      ['title' => 'VS1', 'sort' => 12, 'attribute_id' => 17],
      ['title' => 'VS2', 'sort' => 13, 'attribute_id' => 17],
      ['title' => 'PS1', 'sort' => 14, 'attribute_id' => 17],
      ['title' => 'PS2', 'sort' => 15, 'attribute_id' => 17],
    ];

    foreach ($arrAttributeLists as $arrAttributeList) {
      AttributeListValues::create($arrAttributeList);
    }
    // $this->call("OthersTableSeeder");
  }
}
