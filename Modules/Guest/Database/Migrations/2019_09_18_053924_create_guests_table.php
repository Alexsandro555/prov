<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestsTable extends Migration
{
  private $tableName = 'guests';

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create($this->tableName, function (Blueprint $table) {
      $table->uuid('id')->primary()->comment('Уникальный идентефикатор пользователя');
      $table->string('user_agent', 255)->nullable()->comment('User-Agent');
      $table->string('utm_source', 255)->nullable()->comment('Источник перехода');
      $table->string('utm_medium', 255)->nullable()->comment('Тип трафика');
      $table->string('utm_campaign', 255)->nullable()->comment('Название рекламной кампании');
      $table->string('utm_content', 255)->nullable()->comment('Дополнительная информация');
      $table->string('utm_term',255)->nullable()->comment('Ключевая фраза');
      $table->json('params')->nullable()->comment('Параметры');
      $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
      $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
      $table->softDeletes();
    });

    DB::statement("ALTER TABLE `$this->tableName` comment 'Посетители'");
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists($this->tableName);
  }
}
