<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('room_id');
            $table->string('room_name', 20);
            $table->string('room_type', 30); // Classroom, Laboratory, Office, Gym, etc.
            $table->integer('capacity');
            $table->string('building', 50);
            $table->integer('floor')->nullable();
            $table->string('status', 20)->default('available'); // available, occupied, maintenance
            $table->timestamps();

            $table->unique(['room_name', 'building']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
