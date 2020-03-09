<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surls', function (Blueprint $table) {
            $table->increments('id');
            $table->text('url');
            $table->string('identifier')->unique();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('expires_at')->nullable();
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
        Schema::drop('surls');
    }
}
