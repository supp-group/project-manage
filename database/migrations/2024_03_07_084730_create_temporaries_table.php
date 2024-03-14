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
        Schema::create('temporaries', function (Blueprint $table) {
            $table->id();
            $table->string('NotPad')->nullable();
            $table->string('branch')->nullable();
            $table->bigInteger('IDTeam')->nullable();
            $table->string('FullName')->nullable();
            $table->string('MotherName')->nullable();
            $table->string('PlaceOfBirth')->nullable();
            $table->date('BirthDate')->nullable();
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
            $table->year('DateOfJoin')->nullable();
            $table->string('Specialization')->nullable();
            $table->string('Image')->nullable();  
            $table->string('area')->nullable();
            $table->string('street')->nullable();
            $table->boolean('operation')->nullable();
            $table->boolean('AdminAgree')->default(0)->nullable();
            $table->string('managerEmail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temporaries');
    }
};
