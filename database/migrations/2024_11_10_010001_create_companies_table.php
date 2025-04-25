<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->string('COMPANY_NAME', 100)->comment('会社名');
            $table->date('establishment_date')->nullable()->comment('設立');
            $table->string('director', 100)->nullable()->comment('代表');
            $table->string('POST_CODE', 10)->nullable()->comment('郵便番号');
            $table->string('location', 300)->nullable()->comment('所在地');
            $table->string('content', 300)->nullable()->comment('事業内容');
            $table->string('SNS_1', 200)->nullable()->comment('SNS１');
            $table->string('SNS_2', 200)->nullable()->comment('SNS２');
            $table->string('SNS_3', 200)->nullable()->comment('SNS３');
            $table->string('SPARE1', 300)->nullable()->comment('予備１');
            $table->string('SPARE2', 300)->nullable()->comment('予備２');
            $table->timestamp('INS_DATE')->useCurrent()->comment('登録日');
            $table->timestamp('UPD_DATE')->useCurrent()->comment('更新日');
            $table->char('DEL_FLG', 2)->default('0')->comment('削除フラグ');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });

        DB::statement("ALTER TABLE `companies` comment '会社情報'");

        // Insert initial data with current timestamp for INS_DATE and UPD_DATE
        DB::table('companies')->insert([
            'COMPANY_NAME' => 'コスプラットフォーム株式会社',
            'ESTABLISHMENT_DATE' => '2024-05-01',
            'DIRECTOR' => '鈴木美帆',
            'POST_CODE' => '105-0014',
            'LOCATION' => '東京都港区芝１丁目９−２',
            'CONTENT' => 'タレントマネジメント、衣装販売、レンタル、製作',
            'SNS_1' => 'https://x.com/cosplatform',
            'SNS_2' => 'https://instagram.com/cosplatform',
            'SNS_3' => 'https://tiktok.com/@cosplatform',
            'INS_DATE' => DB::raw('CURRENT_TIMESTAMP'),
            'UPD_DATE' => DB::raw('CURRENT_TIMESTAMP'),
            'DEL_FLG' => '0'
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
}