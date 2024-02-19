<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estate', function (Blueprint $table) {
            $table->id();
            $table->enum('outlook', ['inner', 'school', 'mosque','publicRoad']);
            $table->enum('direction1', ['south', 'north']);
            $table->enum('direction2', ['east','west']);
            $table->enum('floor',['1','2','3','4','5','6']);
            $table->enum('ownership',['taboo','shares','courtRuling,']);
            $table->integer('room_number');
            $table->integer('bath_number');
            $table->double('price');
            $table->string('facilities');
            $table->enum('seller',['owner','agent','dealer',]);
            $table->boolean('place_for_barbecue');
            $table->boolean('parking');
            $table->boolean('left');
            $table->boolean('TV_cable');
            $table->boolean('internet');
            $table->boolean('central_heating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estate');
    }
};
