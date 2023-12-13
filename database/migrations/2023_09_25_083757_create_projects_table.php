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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 255);
            $table->text('description');
            $table->integer('team_size');       // Number of students needed
            $table->integer('trimester')->constrained(1, 3);
            $table->integer('year');
            $table->string('coordinator_name'); //who ganna operate/manager the project
            $table->string('coordinator_email');
            $table->string('complexity');
            $table->unsignedBigInteger('inpID');    // FK
            $table->foreign('inpID')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
