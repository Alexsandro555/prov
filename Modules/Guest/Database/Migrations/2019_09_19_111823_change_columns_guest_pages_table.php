<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsGuestPagesTable extends Migration
{
  private $tableName = 'guest_pages';

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table($this->tableName, function (Blueprint $table) {
      $table->text('referer')->change();
      $table->text('url')->change();
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
      $table->string('referer', 255)->change();
      $table->string('url',255)->change();
    });
  }
}
