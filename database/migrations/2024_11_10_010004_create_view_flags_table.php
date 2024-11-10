<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateViewFlagsTable extends Migration
{
    public function up()
    {
        Schema::create('view_flags', function (Blueprint $table) {
            $table->char('VIEW_FLG', 4)->primary()->comment('表示フラグID');
            $table->string('COMMENT', 300)->nullable()->comment('表示先');
            $table->string('SPARE1', 300)->nullable()->comment('予備１');
            $table->string('SPARE2', 300)->nullable()->comment('予備２');
            $table->timestamp('INS_DATE')->useCurrent()->comment('登録日');
            $table->timestamp('UPD_DATE')->useCurrent()->comment('更新日');
            $table->char('DEL_FLG', 2)->default('0')->comment('削除フラグ');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });

        DB::statement("ALTER TABLE `view_flags` comment 'HP表示管理'");

        // データの挿入
        $data = [
            ['00  ', '非公開', null, null, '0 '],
            ['01  ', 'TALENTページに表示', null, null, '0 '],
            ['02  ', 'TALENTページに表示(切り替えのほう)', null, null, '0 '],
            ['03  ', 'TALENT個人ページに表示', null, null, '0 '],
            ['S001', 'TOPページのバックグラウンド画像', null, null, '0 '],
            ['S002', 'ABOUTページのバックグラウンド画像', null, null, '0 '],
            ['S003', 'TALENTページのバックグラウンド画像', null, null, '0 '],
            ['S004', 'COSPLAYページのバックグラウンド画像', null, null, '0 '],
            ['S005', 'CONTACTページのバックグラウンド画像', null, null, '0 '],
            ['S006', 'NEWSページのバックグラウンド画像', null, null, '0 '],
            ['S102', 'ABOUTページのトップ画像', null, null, '0 '],
            ['S103', 'TALENTページのトップ画像', null, null, '0 '],
            ['S104', 'COSPLAYページのトップ画像', null, null, '0 '],
            ['S105', 'CONTACTページのトップ画像', null, null, '0 '],
            ['S106', 'NEWSページのトップ画像', null, null, '0 '],
            ['S201', 'TOPページのスライドショー', null, null, '0 '],
            ['S203', 'TOPページのCOSPLAYに表示', null, null, '0 '],
            ['S204', 'TOPページの画像', null, null, '0 '],
            ['S301', 'ABOUTページの画像', null, null, '0 '],
            ['S401', 'COSPLAYページの上に表示', null, null, '0 '],
            ['S402', 'COSPLAYページの下に表示', null, null, '0 '],
            ['S999', 'ロゴ', null, null, '0 '],
        ];

        foreach ($data as $item) {
            DB::table('view_flags')->insert([
                'VIEW_FLG' => $item[0],
                'COMMENT' => $item[1],
                'SPARE1' => $item[2],
                'SPARE2' => $item[3],
                'INS_DATE' => DB::raw('CURRENT_TIMESTAMP'),
                'UPD_DATE' => DB::raw('CURRENT_TIMESTAMP'),
                'DEL_FLG' => $item[4],
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('view_flags');
    }
}