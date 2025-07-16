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
        Schema::create('talent_career_category_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('talent_id');
            $table->integer('career_category_id');
            $table->integer('priority')->default(0);
            $table->timestamps();

            $table->foreign('talent_id')->references('TALENT_ID')->on('talents')->onDelete('cascade');
            $table->foreign('career_category_id')->references('CAREER_CATEGORY_ID')->on('career_categories')->onDelete('cascade');

            // talent_id と career_category_id の組み合わせがユニークであることを保証
            $table->unique(['talent_id', 'career_category_id'], 't_c_c_orders_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('talent_career_category_orders');
    }
};
