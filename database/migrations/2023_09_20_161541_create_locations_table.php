<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Location name
            $table->decimal('latitude', 10, 7); // Latitude (up to 7 decimal places)
            $table->decimal('longitude', 10, 7);
            $table->json('points')->nullable(); // JSON column to store drawn region points
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('locations');
    }
}

