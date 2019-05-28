<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Attribute;

class AttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Model::unguard();

      $arrAttributes = [
        ['title' => 'Диаметр (D)', 'attribute_type_id' => 8, 'attribute_group_id' => 1],
        ['title' => 'Толщина', 'attribute_type_id' => 8, 'attribute_group_id' => 1],
        ['title' => 'Длина', 'attribute_type_id' => 8, 'attribute_group_id' => 1],
        ['title' => 'Радиус', 'attribute_type_id' => 8, 'attribute_group_id' => 1],
        ['title' => 'Тип трубы', 'attribute_type_id' => 8, 'attribute_group_id' => 1],
        ['title' => 'Диаметр проволоки', 'attribute_type_id' => 8, 'attribute_group_id' => 1],
        ['title' => 'Диаметр шайбы', 'attribute_type_id' => 8, 'attribute_group_id' => 1],
        ['title' => 'Шаг между шайбами', 'attribute_type_id' => 8, 'attribute_group_id' => 1],
        ['title' => 'Диаметр тросса', 'attribute_type_id' => 8, 'attribute_group_id' => 1],
      ];

      foreach ($arrAttributes as $arrAttribute) {
        Attribute::create($arrAttribute);
      }
    }
}
