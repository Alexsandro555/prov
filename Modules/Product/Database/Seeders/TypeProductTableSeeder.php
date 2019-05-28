<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\TypeProduct;

class TypeProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $arrTypeProducts = [
              ['title' => 'Цепь с шайбами', 'tnved_id' => 125678125545433, 'product_category_id' => 1],
              ['title' => 'Трос с шайбами','tnved_id' => 125678125545433, 'product_category_id' => 1],
              ['title' => 'Лента пометоудаления полипропиленовая','tnved_id' => 125678125545433, 'product_category_id' => 2],
              ['title' => 'Медикаторы','tnved_id' => 125678125545433, 'product_category_id' => 3],
              ['title' => 'Трубы кормления ПВХ','tnved_id' => 125678125545433, 'product_category_id' => 1],
              ['title' => 'Спирали','tnved_id' => 125678125545433, 'product_category_id' => 1],
              ['title' => 'Кормушки','tnved_id' => 125678125545433, 'product_category_id' => 1],
              ['title' => 'Лента яйцесбора полипропиленовая','tnved_id' => 125678125545433, 'product_category_id' => 2],
              ['title' => 'Резинотканевая лента пометоудаления','tnved_id' => 125678125545433, 'product_category_id' => 2],
              ['title' => 'Каплеуловители','tnved_id' => 125678125545433, 'product_category_id' => 3],
              ['title' => 'Трубы квадратного сечения','tnved_id' => 125678125545433, 'product_category_id' => 3],
              ['title' => 'Ниппельные поилки','tnved_id' => 125678125545433, 'product_category_id' => 3],
              ['title' => 'Оцинкованные трубы','tnved_id' => 125678125545433, 'product_category_id' => 1],
              ['title' => 'Система подвеса','tnved_id' => 125678125545433, 'product_category_id' => 1],
              ['title' => 'Поворотные устройства','tnved_id' => 125678125545433, 'product_category_id' => 1],
              ['title' => 'Сепаратор навоза','tnved_id' => 125678125545433, 'product_category_id' => 6],
              ['title' => 'Вентиляторы','tnved_id' => 125678125545433, 'product_category_id' => 4],
              ['title' => 'Аппарат по спайке ленты','tnved_id' => 125678125545433, 'product_category_id' => 2],
              ['title' => 'Жёлоб ОБН','tnved_id' => 125678125545433, 'product_category_id' => 1],
        ];

        foreach ($arrTypeProducts as $arrTypeProduct) {
              TypeProduct::create(['title' => $arrTypeProduct['title'], 'tnved_id' => $arrTypeProduct['tnved_id'], 'product_category_id' => $arrTypeProduct['product_category_id']]);
        }
    }
}


