<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class ModifyImagesTable extends Migration
{
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            //TALENT_IDの後ろにNEWS_IDを追加
            $table->integer('NEWS_ID')->nullable()->comment('ニュースID（外部キー）')->after('TALENT_ID');

            $table->foreign('NEWS_ID')->references('NEWS_ID')->on('news')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropForeign('images_news_id_foreign');
            $table->dropColumn('NEWS_ID');
        });
    }
}
