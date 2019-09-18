<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestPagesTable extends Migration
{
  private $tableName = 'guest_pages';

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create($this->tableName, function (Blueprint $table) {
      $table->increments('id')->comment('Идентефикатор');
      $table->string('url', 255)->comment('url-адрес');
      $table->string('referer', 255)->nullable()->comment('URL-адрес источника');
      $table->string('ip', 50)->nullable()->comment('IP-адрес');
      $table->char('guest_id', 36)->comment('Uuid посетителя');
      $table->foreign('guest_id')->references('id')->on('guests')->onDelete('cascade');
      $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
      $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
      $table->softDeletes();
    });

    DB::statement("ALTER TABLE `$this->tableName` comment 'Посещаемые страницы'");
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table($this->tableName, function (Blueprint $table) {
      $table->dropForeign('guest_pages_guest_id_foreign');
    });
    Schema::dropIfExists($this->tableName);
  }
}
