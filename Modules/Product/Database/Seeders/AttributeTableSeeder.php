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
        ['title' => 'Общее передаточное число редуктора (i)', 'attribute_type_id' => 8, 'attribute_group_id' => 1],
        ['title' => 'Передаточное число быстроходной ступени редуктора (i₁)', 'attribute_type_id' => 3, 'attribute_group_id' => 1],
        ['title' => 'Передаточное число тихоходной ступени редуктора (i₂)', 'attribute_type_id' => 3, 'attribute_group_id' => 1],
        ['title' => 'Номинальный (табличный) крутящий момент на выходном валу редуктора (T₂)', 'attribute_type_id' => 3, 'attribute_unit_id' => 1, 'attribute_group_id' => 1],
        ['title' => 'Номинальная (табличная) частота вращения входного вала редуктора (n₁)', 'attribute_type_id' => 3, 'attribute_unit_id' => 2, 'attribute_group_id' => 1],
        ['title' => 'Номинальная (табличная) частота вращения выходного вала редуктора (n₂)', 'attribute_type_id' => 3, 'attribute_unit_id' => 2, 'attribute_group_id' => 1],
        ['title' => 'Номинальная (табличная) мощность электродвигателя (P₁)', 'attribute_type_id' => 8, 'attribute_unit_id' => 3, 'attribute_group_id' => 2],
        ['title' => 'Вес (m)', 'attribute_type_id' => 4, 'attribute_unit_id' => 5, 'attribute_group_id' => 1],
        ['title' => 'Размер фланца (N)', 'attribute_type_id' => 3, 'attribute_unit_id' => 7, 'attribute_group_id' => 4],
        ['title' => 'Размер фланца (M)', 'attribute_type_id' => 3, 'attribute_unit_id' => 7, 'attribute_group_id' => 4],
        ['title' => 'Размер фланца (P)', 'attribute_type_id' => 3, 'attribute_unit_id' => 7, 'attribute_group_id' => 4],
        ['title' => 'Диаметр входного полого вала (D)', 'attribute_type_id' => 3, 'attribute_unit_id' => 7, 'attribute_group_id' => 4],
        ['title' => 'Фланец под двигатель (входной)', 'attribute_type_id' => 8, 'attribute_group_id' => 4],
        ['title' => 'Вхоной вал', 'attribute_type_id' => 8, 'attribute_group_id' => 5],
        ['title' => 'Расположение выходного фланца', 'attribute_type_id' => 8, 'attribute_group_id' => 5],
        ['title' => 'Выходной вал', 'attribute_type_id' => 8, 'attribute_group_id' => 5],
        ['title' => 'Вариант сборки (монтажное исполнение)', 'attribute_type_id' => 8, 'attribute_group_id' => 5],
        ['title' => 'Электродвигатель', 'attribute_type_id' => 8, 'attribute_group_id' => 5],
        ['title' => 'Расположение клеммной коробки', 'attribute_type_id' => 8, 'attribute_group_id' => 5],
        ['title' => 'A', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'A1', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'B', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'D', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'D1', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'G', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'G1', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'G3', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'H', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'H1', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'I', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'K', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'KE', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'L', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'M', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'N', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'N1', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'O', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'P', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'Q', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'R', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'S', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'S1', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'T', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'V', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'W', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'b', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 't', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'b1', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 't1', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6],
        ['title' => 'f', 'attribute_type_id' => 4, 'attribute_unit_id' => 7, 'attribute_group_id' => 6]
      ];

      foreach ($arrAttributes as $arrAttribute) {
        Attribute::create($arrAttribute);
      }
    }
}
