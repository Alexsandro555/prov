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
        ['title' => 'Механические свойства'],
        ['title' => 'Электрические свойства'],
        ['title' => 'Характеристики червячного зацепления'],
        ['title' => 'Конструктивные размеры червячных редукторов серии NMRV c фланцами под двигатель'],
        ['title' => 'Конструктивные особенности'],
        ['title' => 'Габаритные и присоединительные размеры'],
      ];

      foreach ($arrAttributeGroups as $arrAttributeGroup) {
        AttributeGroup::create(['title' => $arrAttributeGroup['title']]);
      }

    }
}
