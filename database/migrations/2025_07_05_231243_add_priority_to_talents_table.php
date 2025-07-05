<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('talents', function (Blueprint $table) {
            $table->integer('PRIORITY')->default(0)->after('SPARE3')->comment('表示優先度');
        });
    }

    public function down(): void
    {
        Schema::table('talents', function (Blueprint $table) {
            $table->dropColumn('PRIORITY');
        });
    }
};
