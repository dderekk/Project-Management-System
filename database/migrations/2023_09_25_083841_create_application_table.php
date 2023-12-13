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
        Schema::create('application', function (Blueprint $table) {
            //NOTE: id is guaranteed to be a primary key and is unique and auto-incrementing.
            $table->id();
            $table->timestamps();

            $table->text('justification');
            $table->unsignedBigInteger('studentID');       //FK
            $table->unsignedBigInteger('projectID');       //FK
            
            $table->foreign('studentID')->references('id')->on('users')->onDelete('cascade');;
            $table->foreign('projectID')->references('id')->on('projects')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application');
    }
};
