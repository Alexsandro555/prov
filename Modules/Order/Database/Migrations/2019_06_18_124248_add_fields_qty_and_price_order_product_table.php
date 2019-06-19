<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsQtyAndPriceOrderProductTable extends Migration
{
  private $tableName = 'order_product';

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table($this->tableName, function (Blueprint $table) {
      $table->integer('qty')->default(1)->comment('Колличество товара');
      $table->decimal('price',10,2)->comment('Цена');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table($this->tableName, function (Blueprint $table) {
      $table->dropColumn('price');
      $table->dropColumn('qty');
    });
  }
}
