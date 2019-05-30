<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldSkuProductsTable extends Migration
{
  private $tableName = 'products';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table($this->tableName, function (Blueprint $table) {
        $table->boolean('sku')->default(false)->comment('Товар с торговыми предложениями');
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
        $table->dropColumn('sku');
      });
    }
}
