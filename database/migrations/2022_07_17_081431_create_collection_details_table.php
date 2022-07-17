<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_details', function (Blueprint $table) {
            $table->integer('collection_id')->comment('収蔵品ID');
            $table->smallInteger('lang_code')->comment('言語コード');
            $table->integer('item_id')->comment('収蔵品項目ID');
            $table->string('collection_note', 2048)->nullable()->comment('値');

            $table->primary(['collection_id', 'lang_code', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collection_details');
    }
}
