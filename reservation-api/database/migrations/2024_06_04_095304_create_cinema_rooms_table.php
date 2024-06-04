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
        Schema::create('cinema_rooms', function (Blueprint $table) {
            $table->id();
            $table->uuid('cinema_id');
            $table->uuid('room_id');
            $table->foreignUuid('cinema_id')->references('id')->on('cinemas')->onDelete('cascade');
            $table->foreignUuid('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cinema_rooms');
    }
};
