<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateTalentTagsTable extends Migration
{
    public function up()
    {
        Schema::create('talent_tags', function (Blueprint $table) {
            $table->integer('TALENT_ID')->comment('タレントID（外部キー）');
            $table->integer('TAG_ID')->comment('タグID（外部キー）');
            $table->string('SPARE1', 200)->nullable()->comment('予備１');
            $table->string('SPARE2', 200)->nullable()->comment('予備２');

            $table->foreign('TALENT_ID')->references('TALENT_ID')->on('talents')->onDelete('cascade');
            $table->foreign('TAG_ID')->references('TAG_ID')->on('tags')->onUpdate('cascade');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });

        DB::statement("ALTER TABLE `talent_tags` comment 'タレントタグ'");
    }

    public function down()
    {
        Schema::dropIfExists('talent_tags');
    }
}