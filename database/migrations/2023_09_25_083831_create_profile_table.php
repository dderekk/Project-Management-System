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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('studentID');          //PK,FK
            $table->timestamps();
            
            $table->foreign('studentID')->references('id')->on('users');

            $table->float('GPA');
            $table->integer('softwareDeveloper');
            $table->integer('projectManager');
            $table->integer('businessAnalyst');
            $table->integer('tester');
            $table->integer('clientLiaison');
            $table->integer('graduation_year');
            $table->integer('graduation_trimester')->constrained(1, 3);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
