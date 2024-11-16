<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateContactCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('contact_categories', function (Blueprint $table) {
            $table->integer('CONTACT_CATEGORY_ID')->primary()->autoIncrement()->comment('問い合わせカテゴリーID');
            $table->string('CONTACT_CATEGORY_NAME', 300)->comment('問い合わせカテゴリー名');
            $table->char('REFERENCE_CODE', 6)->comment('問い合わせコード');
            $table->string('SPARE1', 300)->nullable()->comment('予備１');
            $table->string('SPARE2', 300)->nullable()->comment('予備２');
            $table->timestamp('INS_DATE')->useCurrent()->comment('登録日');
            $table->timestamp('UPD_DATE')->useCurrent()->comment('更新日');
            $table->char('DEL_FLG', 2)->default('0')->comment('削除フラグ');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });

        DB::statement("ALTER TABLE `contact_categories` comment '問い合わせカテゴリー'");
    }

    public function down()
    {
        Schema::dropIfExists('contact_categories');
    }
}