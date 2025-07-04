<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('costume_client_images', function (Blueprint $table) {
            $table->id('image_id');
            $table->unsignedBigInteger('client_id');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('alt_text')->nullable();
            $table->integer('priority')->default(0);
            $table->timestamps();

            // 外部キー制約
            $table->foreign('client_id')->references('client_id')->on('costume_clients')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('costume_client_images');
    }
};
