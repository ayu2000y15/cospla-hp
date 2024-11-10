<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateCareerCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('career_categories', function (Blueprint $table) {
            $table->integer('CAREER_CATEGORY_ID')->primary()->autoIncrement()->comment('経歴カテゴリID');
            $table->string('CAREER_CATEGORY_NAME', 300)->nullable()->comment('カテゴリ名');
            $table->string('SPARE1', 300)->nullable()->comment('予備１');
            $table->string('SPARE2', 300)->nullable()->comment('予備２');
            $table->timestamp('INS_DATE')->useCurrent()->comment('登録日');
            $table->timestamp('UPD_DATE')->useCurrent()->comment('更新日');
            $table->char('DEL_FLG', 2)->default('0')->comment('削除フラグ');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });

        DB::statement("ALTER TABLE `career_categories` comment '経歴カテゴリ'");
    }

    public function down()
    {
        Schema::dropIfExists('career_categories');
    }
}