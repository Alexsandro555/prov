<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineProductSectionTable extends Migration
{
  private $tableName = 'line_product_section';
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create($this->tableName, function (Blueprint $table) {
      $table->increments('id');
      $table->integer('section_id')->length(11)->unsigned();
      $table->integer('line_product_id')->length(11)->unsigned();
      $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
      $table->foreign('line_product_id')->references('id')->on('line_products')->onDelete('cascade');
      $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
      $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
      $table->softDeletes();
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
      $table->dropForeign('line_product_section_section_id_foreign');
      $table->dropForeign('line_product_section_line_product_id_foreign');
    });
    Schema::dropIfExists($this->tableName);
  }
}
