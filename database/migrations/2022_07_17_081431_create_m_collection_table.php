<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_collection', function (Blueprint $table) {
            $table->integer('collection_id', true)->comment('収蔵品ID');
            $table->smallInteger('collection_genre_id')->comment('収蔵品ジャンルID');
            $table->integer('main_image_id')->nullable()->comment('メイン画像ID');
            $table->tinyInteger('is_public')->comment('公開・非公開');
            $table->timestamp('created_at')->useCurrent()->comment('登録日時');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent()->comment('変更日時');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_collection');
    }
}
