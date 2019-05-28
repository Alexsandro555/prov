<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiguresTable extends Migration
{
  private $tableName = 'figures';
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create($this->tableName, function (Blueprint $table) {
      $table->increments('id');
      $table->smallInteger('x');
      $table->smallInteger('y');
      $table->smallInteger('degree');
      $table->string('color');
      $table->string('type');
      $table->unsignedInteger('file_id');
      $table->unsignedInteger('attribute_id');
      $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
      $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
      $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
      $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
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
      $table->dropForeign('figures_attribute_id_foreign');
      $table->dropForeign('figures_file_id_foreign');
    });
    Schema::dropIfExists($this->tableName);
  }
}
