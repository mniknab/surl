<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurlImpressionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surl_impressions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('surl_id');
            $table->timestamps();

            $table->foreign('surl_id')
                ->references('id')
                ->on('surls')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('surl_impressions');
    }
}
