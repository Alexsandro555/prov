<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSectionTable extends Migration
{
  private $tableName = "product_section";
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create($this->tableName, function (Blueprint $table) {
      $table->increments('id')->comment('Идентефикатор');
      $table->unsignedInteger('product_id')->length(11)->comment('Продукт');
      $table->unsignedInteger('section_id')->length(11)->comment('Секция');
      $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
      $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
      $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
      $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
      $table->softDeletes();
    });

    DB::statement("ALTER TABLE `$this->tableName` comment 'Разделы продуктов'");
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table($this->tableName, function (Blueprint $table) {
      $table->dropForeign('product_section_product_id_foreign');
      $table->dropForeign('product_section_section_id_foreign');
    });
    Schema::dropIfExists($this->tableName);
  }
}
