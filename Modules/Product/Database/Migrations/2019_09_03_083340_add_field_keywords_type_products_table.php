<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldKeywordsTypeProductsTable extends Migration
{
  private $tableName = 'type_products';

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table($this->tableName, function (Blueprint $table) {
      $table->string('meta_title', 80)->nullable()->comment('Шаблон META TITLE');
      $table->string('meta_description', 300)->nullable()->comment('Шаблон META KEYWORDS');
      $table->string('meta_keywords', 255)->nullable()->comment('Шаблон META DESCRIPTION');
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
      $table->dropColumn('meta_keywords');
      $table->dropColumn('meta_description');
      $table->dropColumn('meta_title');
    });
  }
}
