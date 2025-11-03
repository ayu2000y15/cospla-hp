<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSortOrderToTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            // 既存テーブルの命名が大文字カラムを使っているため、こちらも大文字で追加します
            $table->integer('SORT_ORDER')->default(0)->after('TAG_COLOR');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tags', function (Blueprint $table) {
            if (Schema::hasColumn('tags', 'SORT_ORDER')) {
                $table->dropColumn('SORT_ORDER');
            }
        });
    }
}
