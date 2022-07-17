<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_lang', function (Blueprint $table) {
            $table->integer('collection_id')->comment('収蔵品ID');
            $table->smallInteger('lang_code')->comment('言語コード');
            $table->string('collection_title', 250)->nullable()->comment('タイトル');
            $table->string('collection_title_kana', 250)->nullable()->comment('タイトルカナ');
            $table->json('common_items')->nullable()->comment('共通項目 (JSON)');
            $table->json('custom_items')->nullable()->comment('カスタム項目 (JSON)');
            $table->text('collection_note')->nullable()->comment('収蔵品備考');
            $table->timestamp('created_at')->useCurrent()->comment('登録日時');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent()->comment('変更日時');

            $table->primary(['collection_id', 'lang_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collection_lang');
    }
}
