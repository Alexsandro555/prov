<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\LineProduct;

class LineProductTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    $arrLineProducts = [
      ['title' => 'Плетеная', 'type_product_id' => 3],
      ['title' => 'Перфорированная', 'type_product_id' => 3],
      ['title' => 'Лебедка потолочная (ручной лифт)', 'type_product_id' => 14],
      ['title' => 'Прямые трубы кормления', 'type_product_id' => 5],
      ['title' => 'Изогнутые трубы кормления', 'type_product_id' => 5],
      ['title' => 'Поворотное устройство для трос-шайбы', 'type_product_id' => 15],
      ['title' => 'Станция поворотная ОБН', 'type_product_id' => 15],
      ['title' => 'Блок РТШ в сборе', 'type_product_id' => 15],
      ['title' => 'Поворотное устройство для цепь-шайбы', 'type_product_id' => 15],
    ];

    foreach ($arrLineProducts as $arrLineProduct) {
      LineProduct::create(['title' => $arrLineProduct['title'],  'type_product_id' => $arrLineProduct['type_product_id']]);
    }
  }
}
