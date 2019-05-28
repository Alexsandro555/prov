<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\AttributeGroup;

class AttributeGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Model::unguard();

      $arrAttributeGroups = [
        ['title' => 'Характеристики'],
      ];

      foreach ($arrAttributeGroups as $arrAttributeGroup) {
        AttributeGroup::create(['title' => $arrAttributeGroup['title']]);
      }

    }
}
