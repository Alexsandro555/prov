<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  private $tableName = 'sections';

  public function up()
  {
    Schema::create($this->tableName, function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('remote_id')->nullable();
      $table->string('title', 255)->comment('Название раздела');
      $table->boolean('active')->default(true)->comment('Актив.');
      $table->string('url_key', 255)->comment('Путь');
      $table->unsignedInteger('sort')->nullable()->comment('Сорт.');
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
    Schema::dropIfExists($this->tableName);
  }
}
