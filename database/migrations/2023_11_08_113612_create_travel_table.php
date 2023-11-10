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
        Schema::create('travel', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('isPublic')->default(0);
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('description');
            $table->integer('numberOfDays');
            $table->integer('numberOfNights');
            $table->json('moods');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travels');
    }
};