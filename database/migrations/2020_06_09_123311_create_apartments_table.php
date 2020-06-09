<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->text('title');
            $table->string('slug')->unique();
            $table->unsignedTinyInteger('rooms');
            $table->unsignedTinyInteger('beds');
            $table->unsignedSmallInteger('mq');
            $table->text('address');
            $table->string('longitude');
            $table->string('latitude');
            $table->text('img_path');
            $table->boolean('visible')->default(1);
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
        Schema::dropIfExists('apartments');
    }
}
