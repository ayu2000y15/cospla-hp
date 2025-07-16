<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            // CONTENTカラムの後に公開ステータス用のカラムを追加します。
            // 0: 下書き/非公開, 1: 公開中
            $table->boolean('published_status')->default(false)->after('CONTENT')->comment('0:非公開, 1:公開');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            // マイグレーションをロールバックする際にカラムを削除します。
            $table->dropColumn('published_status');
        });
    }
};
