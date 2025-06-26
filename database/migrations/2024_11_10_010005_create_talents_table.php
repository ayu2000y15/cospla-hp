<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateTalentsTable extends Migration
{
    public function up()
    {
        Schema::create('talents', function (Blueprint $table) {
            $table->integer('TALENT_ID')->primary()->autoIncrement()->comment('タレントID');
            $table->string('TALENT_NAME', 100)->nullable()->comment('名前');
            $table->string('TALENT_FURIGANA_JP', 200)->nullable()->comment('ふりがな（平仮名）');
            $table->string('TALENT_FURIGANA_EN', 200)->nullable()->comment('ふりがな（英語）');
            $table->string('LAYER_NAME', 100)->nullable()->comment('レイヤーネーム（HPに表示する名前）');
            $table->string('LAYER_FURIGANA_JP', 200)->nullable()->comment('レイヤーネーム　ふりがな（平仮名）');
            $table->string('LAYER_FURIGANA_EN', 200)->nullable()->comment('レイヤーネーム　ふりがな（英語）');
            $table->integer('FOLLOWERS')->nullable()->comment('フォロワー数');
            $table->char('STREAM_FLG', 2)->default('0')->comment('配信可・不可');
            $table->char('COS_FLG', 2)->nullable()->comment('メインコスプレ');
            $table->integer('HEIGHT')->nullable()->comment('身長');
            $table->integer('AGE')->nullable()->comment('年齢');
            $table->date('BIRTHDAY')->nullable()->comment('誕生日');
            $table->integer('THREE_SIZES_B')->nullable()->comment('スリーサイズ　バスト');
            $table->integer('THREE_SIZES_W')->nullable()->comment('スリーサイズ　ウエスト');
            $table->integer('THREE_SIZES_H')->nullable()->comment('スリーサイズ　ヒップ');
            $table->string('HOBBY_SPECIALTY', 200)->nullable()->comment('趣味・特技');
            $table->string('COMMENT', 500)->nullable()->comment('紹介文');
            $table->date('AFFILIATION_DATE')->nullable()->comment('所属日');
            $table->date('RETIREMENT_DATE')->default('2099-01-01')->comment('退職日');
            $table->string('MAIL', 200)->nullable()->comment('メールアドレス');
            $table->string('TEL_NO', 50)->nullable()->comment('電話番号');
            $table->string('SNS_1', 200)->nullable()->default('#')->comment('SNS１');
            $table->string('SNS_2', 200)->nullable()->default('#')->comment('SNS２');
            $table->string('SNS_3', 200)->nullable()->default('#')->comment('SNS３');
            $table->string('SPARE1', 300)->nullable()->comment('予備１');
            $table->string('SPARE2', 300)->nullable()->comment('予備２');
            $table->string('SPARE3', 300)->nullable()->comment('予備３');
            $table->timestamp('INS_DATE')->useCurrent()->comment('登録日');
            $table->timestamp('UPD_DATE')->useCurrent()->comment('更新日');
            $table->char('DEL_FLG', 2)->default('0')->comment('削除フラグ');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });

        DB::statement("ALTER TABLE `talents` comment 'タレント'");
    }

    public function down()
    {
        Schema::dropIfExists('talents');
    }
}