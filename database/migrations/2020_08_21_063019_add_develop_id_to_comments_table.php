<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDevelopIdToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->integer('develop_id');
        });
    }
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('develop_id');  //カラムの削除
        });
    }
}
