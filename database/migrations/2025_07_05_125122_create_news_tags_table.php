<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news_tags', function (Blueprint $table) {
            $table->id();
            // 既存のテーブルのキー名に合わせて、型とカラム名を明示的に指定
            $table->integer('news_id');
            $table->integer('tag_id');

            $table->timestamps();

            // 参照先のカラム名を正しく指定
            $table->foreign('news_id')->references('NEWS_ID')->on('news')->onDelete('cascade');
            $table->foreign('tag_id')->references('TAG_ID')->on('tags')->onDelete('cascade');

            // 同じニュースに同じタグが複数つかないようにユニーク制約
            $table->unique(['news_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_tags');
    }
};
