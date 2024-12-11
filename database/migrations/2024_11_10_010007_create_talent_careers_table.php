<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTalentCareersTable extends Migration
{
    public function up()
    {
        Schema::create('talent_careers', function (Blueprint $table) {
            $table->integer('CAREER_ID')->primary()->autoIncrement()->comment('経歴ID');
            $table->integer('TALENT_ID')->comment('タレントID（外部キー）');
            $table->integer('CAREER_CATEGORY_ID')->comment('経歴カテゴリID（外部キー）');
            $table->string('CONTENT', 100000)->nullable()->comment('経歴内容');
            $table->string('DETAIL', 100000)->nullable()->comment('経歴詳細');
            $table->date('ACTIVE_DATE')->nullable()->comment('活動日（表示では月まで）');
            $table->string('SPARE1', 300)->nullable()->comment('予備１');
            $table->string('SPARE2', 300)->nullable()->comment('予備２');
            $table->timestamp('INS_DATE')->useCurrent()->comment('登録日');
            $table->timestamp('UPD_DATE')->useCurrent()->comment('更新日');
            $table->char('DEL_FLG', 2)->default('0')->comment('削除フラグ');

            $table->foreign('TALENT_ID')->references('TALENT_ID')->on('talents')->onDelete('cascade');
            $table->foreign('CAREER_CATEGORY_ID')->references('CAREER_CATEGORY_ID')->on('career_categories')->onUpdate('cascade');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });

        DB::statement("ALTER TABLE `talent_careers` comment 'タレント経歴'");
    }

    public function down()
    {
        Schema::dropIfExists('talent_careers');
    }
}
