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
            $table->char('view_flg', 20)->primary()->comment('表示フラグID');
            $table->string('comment', 300)->nullable()->comment('表示先');
            $table->integer('max_count')->default(0)->comment('最大枚数');
            $table->string('spare1', 300)->nullable()->comment('予備１');
            $table->string('spare2', 300)->nullable()->comment('予備２');
            $table->timestamp('created_at')->useCurrent()->comment('登録日');
            $table->timestamp('updated_at')->useCurrent()->comment('更新日');
            $table->char('delete_flg', 2)->default('0')->comment('削除フラグ');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });

        DB::statement("ALTER TABLE `view_flags` comment 'HP表示管理'");
    }

    public function down()
    {
        Schema::dropIfExists('view_flags');
    }
}
