<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateContactsTable extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->integer('CONTACT_ID')->primary()->autoIncrement()->comment('問い合わせID');
            $table->char('REFERENCE_NUMBER', 8)->nullable()->unique()->comment('問い合わせ番号（ユーザー用）');
            $table->integer('CONTACT_CATEGORY_ID')->comment('問い合わせカテゴリーID(外部キー)');
            $table->string('NAME', 200)->nullable()->comment('氏名');
            $table->integer('AGE')->nullable()->comment('年齢');
            $table->string('MAIL', 200)->nullable()->comment('メールアドレス');
            $table->string('TEL', 30)->nullable()->comment('電話番号');
            $table->string('SUBJECT', 400)->nullable()->comment('件名');
            $table->string('CONTENT', 10000)->nullable()->comment('本文');
            $table->string('MEMO', 10000)->nullable()->comment('備考');
            $table->timestamp('INS_DATE')->useCurrent()->comment('登録日');
            $table->timestamp('UPD_DATE')->useCurrent()->comment('更新日');
            $table->char('REPLY_FLG', 2)->default('0')->comment('返信フラグ');

            $table->foreign('CONTACT_CATEGORY_ID')->references('CONTACT_CATEGORY_ID')->on('contact_categories')->onUpdate('cascade');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });

        DB::statement("ALTER TABLE `contacts` comment '問い合わせ'");
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}