<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\AttributeUnit;

class AttributeUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Model::unguard();

      $arrAttributeUnits = [
        ['title' => 'Нм'],
        ['title' => 'об/мин.'],
        ['title' => 'кВт'],
        ['title' => 'H'],
        ['title' => 'кг'],
        ['title' => 'л'],
        ['title' => 'мм'],
      ];

      foreach ($arrAttributeUnits as $arrAttributeUnit) {
        AttributeUnit::create(['title' => $arrAttributeUnit['title']]);
      }
    }
}
