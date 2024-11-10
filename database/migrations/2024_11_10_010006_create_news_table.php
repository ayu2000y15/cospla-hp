<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateNewsTable extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->integer('NEWS_ID')->primary()->autoIncrement()->comment('ニュースID');
            $table->string('TITLE', 100)->nullable()->comment('タイトル');
            $table->text('CONTENT')->nullable()->comment('内容');
            $table->date('POST_DATE')->nullable()->comment('投稿日');
            $table->string('SPARE1', 300)->nullable()->comment('予備１');
            $table->string('SPARE2', 300)->nullable()->comment('予備２');
            $table->timestamp('INS_DATE')->useCurrent()->comment('登録日');
            $table->timestamp('UPD_DATE')->useCurrent()->comment('更新日');
            $table->char('DEL_FLG', 2)->default('0')->comment('削除フラグ');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });

        DB::statement("ALTER TABLE `news` comment 'ニュース'");
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
}