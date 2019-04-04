<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("title");
            $table->string("usage")->nullable();
            $table->longText("path");
            $table->string("format");
            $table->string("size")->nullable();
            $table->integer("orders")->nullable();
            $table->integer("user_id")->nullable();
            $table->integer("assetable_id")->nullable();
            $table->string("assetable_type")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
