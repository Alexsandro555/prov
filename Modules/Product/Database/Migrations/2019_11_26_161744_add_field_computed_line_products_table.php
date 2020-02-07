<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldComputedLineProductsTable extends Migration
{
  private $tableName = 'line_products';

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table($this->tableName, function (Blueprint $table) {
      $table->json('computed')->nullable();
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
      $table->dropColumn('computed');
    });
  }
}
