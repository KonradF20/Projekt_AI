<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Uruchom migrację (tworzenie tabeli).
     */
    public function up(): void
    {
        Schema::create('travel_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('destination');
            $table->string('dates')->nullable();          // DODANE: na ramy czasowe
            $table->json('days')->nullable();             // Twój stary JSON na dni
            $table->json('flight_data')->nullable();      // DODANE: na loty
            $table->json('hotel_data')->nullable();       // DODANE: na hotel
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Cofnij migrację (usuwanie tabeli).
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_plans');
    }
};
