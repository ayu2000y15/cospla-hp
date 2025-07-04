<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('costume_clients', function (Blueprint $table) {
            $table->id('client_id');
            $table->string('client_name'); // グループ名・会社名
            $table->string('client_name_kana')->nullable(); // ふりがな
            $table->text('description')->nullable(); // 紹介文
            $table->string('homepage_url')->nullable(); // HPのURL
            $table->string('sns_x')->nullable(); // X (Twitter)
            $table->string('sns_instagram')->nullable(); // Instagram
            $table->string('sns_tiktok')->nullable(); // TikTok
            $table->boolean('is_visible')->default(true); // 表示・非表示フラグ
            $table->integer('priority')->default(0); // 表示順
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('costume_clients');
    }
};
