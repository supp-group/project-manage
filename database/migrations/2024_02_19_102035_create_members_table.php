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
            $table->string('IDNumber')->nullable();
            $table->string('Gender')->default('ذكر')->nullable();
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
            $table->timestamps();

            //users_table
            // $table->foreignId('user_id')->nullable();
            // $table->unsignedBigInteger('user_id');
            // $table->foreign('user_id')->references('id')->on('users');

             //qualifications_table
            // $table->foreignId('qualification_id')->nullable();
            //  $table->unsignedBigInteger('qualification_id');
            //  $table->foreign('qualification_id')->references('id')->on('qualifications');

              //occupations_table
            // $table->foreignId('occupation_id')->nullable();
            // $table->unsignedBigInteger('occupation_id');
            // $table->foreign('occupation_id')->references('id')->on('occupations');

          
          
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
