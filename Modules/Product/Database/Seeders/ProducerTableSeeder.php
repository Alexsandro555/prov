<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProducerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Model::unguard();
      DB::table('producers')->insert([
        [
          'title' => 'Россия',
          'url_key' => 'russia'
        ],
        [
          'title' => 'Codaf',
          'url_key' => 'codaf'
        ],
        [
          'title' => 'Barbieri',
          'url_key' => 'barbieri'
        ],
        [
          'title' => 'Ярославский завод резинотехнических изделий',
          'url_key' => 'yaroslavl-zavod'
        ],
        [
          'title' => 'Roxell',
          'url_key' => 'roxell'
        ],
        [
          'title' => 'Lubing',
          'url_key' => 'lubing'
        ],
        [
          'title' => 'Dosatron',
          'url_key' => 'dosatron'
        ],
        [
          'title' => 'Стимул-Инк',
          'url_key' => 'stimul-inc'
        ],
        [
          'title' => 'Impex',
          'url_key' => 'impex'
        ],
        [
          'title' => 'Sonowave',
          'url_key' => 'sonowave'
        ],
        [
          'title' => 'SonCLR. Турция',
          'url_key' => 'sonclr-turc'
        ]
      ]);
    }
}
