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
        Schema::create('room_seances', function (Blueprint $table) {
            $table->id();
            $table->uuid('room_id');
            $table->uuid('seance_id');
            $table->foreignUuid('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreignUuid('seance_id')->references('id')->on('seances')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_seances');
    }
};
