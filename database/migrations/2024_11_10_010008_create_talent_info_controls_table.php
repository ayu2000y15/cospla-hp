<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateTalentInfoControlsTable extends Migration
{
    public function up()
    {
        Schema::create('talent_info_controls', function (Blueprint $table) {
            $table->integer('TALENT_ID')->comment('タレントID（外部キー）');
            $table->char('FOLLOWERS_FLG', 2)->default('0')->comment('フォロワー数フラグ');
            $table->char('HEIGHT_FLG', 2)->default('0')->comment('身長フラグ');
            $table->char('AGE_FLG', 2)->default('0')->comment('年齢フラグ');
            $table->char('BIRTHDAY_FLG', 2)->default('0')->comment('誕生日フラグ');
            $table->char('THREE_SIZES_FLG', 2)->default('0')->comment('スリーサイズ　フラグ');
            $table->char('THREE_SIZES_B_FLG', 2)->default('0')->comment('スリーサイズ　バスト　フラグ');
            $table->char('THREE_SIZES_W_FLG', 2)->default('0')->comment('スリーサイズ　ウエスト　フラグ');
            $table->char('THREE_SIZES_H_FLG', 2)->default('0')->comment('スリーサイズ　ヒップ　フラグ');
            $table->char('HOBBY_SPECIALTY_FLG', 2)->default('0')->comment('趣味・特技フラグ');
            $table->char('COMMENT_FLG', 2)->default('0')->comment('紹介文フラグ');
            $table->char('SNS_1_FLG', 2)->default('0')->comment('SNS１フラグ');
            $table->char('SNS_2_FLG', 2)->default('0')->comment('SNS２フラグ');
            $table->char('SNS_3_FLG', 2)->default('0')->comment('SNS３フラグ');
            $table->char('SPARE1', 2)->nullable()->comment('予備１');
            $table->char('SPARE2', 2)->nullable()->comment('予備２');

            $table->foreign('TALENT_ID')->references('TALENT_ID')->on('talents')->onDelete('cascade');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });

        DB::statement("ALTER TABLE `talent_info_controls` comment 'タレント情報コントロール'");
    }

    public function down()
    {
        Schema::dropIfExists('talent_info_controls');
    }
}