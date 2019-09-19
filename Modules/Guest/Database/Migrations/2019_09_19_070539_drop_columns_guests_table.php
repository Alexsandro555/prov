<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnsGuestsTable extends Migration
{
  private $tableName = "guests";

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table($this->tableName, function (Blueprint $table) {
      $table->dropColumn(['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'params']);
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
      $table->string('utm_source', 255)->nullable()->comment('Источник перехода');
      $table->string('utm_medium', 255)->nullable()->comment('Тип трафика');
      $table->string('utm_campaign', 255)->nullable()->comment('Название рекламной кампании');
      $table->string('utm_content', 255)->nullable()->comment('Дополнительная информация');
      $table->string('utm_term',255)->nullable()->comment('Ключевая фраза');
      $table->json('params')->nullable()->comment('Параметры');
    });
  }
}
