<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateAcmailsTable extends Migration
{
    public function up()
    {
        Schema::create('acmails', function (Blueprint $table) {
            $table->integer(column: 'AC_ID')->primary()->autoIncrement()->comment('ID');
            $table->string('MAIL')->nullable()->comment('メールアドレス');
            $table->string('COL1')->nullable()->comment('カラム１');
            $table->string('COL2')->nullable()->comment('カラム２');
            $table->string('COL3')->nullable()->comment('カラム３');
            $table->string('COL4')->nullable()->comment('カラム４');
            $table->string('COL5')->nullable()->comment('カラム５');
            $table->string('COL6')->nullable()->comment('カラム６');
            $table->string('COL7')->nullable()->comment('カラム７');
            $table->string('COL8')->nullable()->comment('カラム８');
            $table->string('COL9')->nullable()->comment('カラム９');
            $table->string('COL10')->nullable()->comment('カラム１０');
            $table->char('DELIVERY_FLG')->nullable()->comment('配信フラグ');
            $table->timestamp('INS_DATE')->useCurrent()->comment('登録日');
            $table->timestamp('UPD_DATE')->useCurrent()->comment('更新日');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });

        DB::statement("ALTER TABLE `acmails` comment 'ACメーラー登録用'");
    }

    public function down()
    {
        Schema::dropIfExists('acmails');
    }
}
