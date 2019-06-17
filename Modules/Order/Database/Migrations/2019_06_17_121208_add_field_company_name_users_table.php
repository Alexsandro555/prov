<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldCompanyNameUsersTable extends Migration
{
  private $tableName = 'users';

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table($this->tableName, function (Blueprint $table) {
      $table->string('company_name', 255)->nullable()->comment('Название компании');
      $table->string('telephone', 15)->nullable()->comment('Телефон');
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
      $table->dropColumn('telephone');
      $table->dropColumn('company_name');
    });
  }
}
