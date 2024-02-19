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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('NotPad')->nullable();
            $table->string('branch')->nullable();
            $table->bigInteger('IDTeam')->unique()->nullable();
            $table->string('FullName')->nullable();
            $table->string('MotherName')->nullable();
            $table->string('PlaceOfBirth')->nullable();
            $table->dateTime('BirthDate')->nullable();
            $table->string('Constraint')->nullable();
            $table->string('City')->nullable();
            $table->string('IDNumber')->unique()->nullable();
            $table->boolean('Gender')->default(0)->nullable();
            $table->string('Qualification')->nullable();
            $table->string('Occupation')->nullable();
            $table->string('MobilePhone')->nullable();
            $table->string('HomeAddress')->nullable();
            $table->string('WorkAddress')->nullable();
            $table->string('HomePhone')->nullable();
            $table->string('WorkPhone')->nullable();
            $table->dateTime('DateOfJoin')->nullable();
            $table->string('Specialization')->nullable();
            $table->string('Image')->nullable();  
            //users_table
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
