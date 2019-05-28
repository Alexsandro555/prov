<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Tnved;

class TnvedTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    $arrTnveds = [
      ['title' => 'Цепь с шайбами', 'id' => 125678125545433],
      ['title' => 'Трос с шайбами', 'id' => 141286],
      ['title' => 'Медикаторы', 'id' => 111111111],
      ['title' => 'Труба кормления ПВХ', 'id' => 222222222],
      ['title' => 'Полипропиленовая лента яйцесбора (плетеная)', 'id' => 3132],
      ['title' => 'Жёлоб ОБН', 'id' => 32321111],
    ];

    foreach ($arrTnveds as $arrTnved) {
      Tnved::create(['title' => $arrTnved['title'], 'id' => $arrTnved['id']]);
    }

  }
}
