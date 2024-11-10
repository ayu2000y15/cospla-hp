<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateImagesTable extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->string('FILE_NAME', 100)->comment('ファイル名');
            $table->integer('TALENT_ID')->nullable()->comment('タレントID（外部キー）');
            $table->string('FILE_PATH', 100)->nullable()->comment('格納先パス');
            $table->char('VIEW_FLG', 4)->default('00')->comment('表示フラグ');
            $table->integer('PRIORITY')->nullable()->comment('表示優先度');
            $table->string('COMMENT', 200)->nullable()->comment('写真の説明(alt)');
            $table->string('SPARE1', 200)->nullable()->comment('予備１');
            $table->string('SPARE2', 200)->nullable()->comment('予備２');
            $table->timestamp('INS_DATE')->useCurrent()->comment('登録日');
            $table->timestamp('UPD_DATE')->useCurrent()->comment('更新日');
            $table->char('DEL_FLG', 2)->default('0')->comment('削除フラグ');

            $table->foreign('TALENT_ID')->references('TALENT_ID')->on('talents')->onDelete('cascade');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });

        DB::statement("ALTER TABLE `images` comment '写真一覧'");
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
}