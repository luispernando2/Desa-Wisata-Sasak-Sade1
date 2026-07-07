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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // create, update, delete
            $table->string('module'); // products, events, galleries, etc
            $table->text('description');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('item_id')->nullable(); // ID dari item yang diubah
            $table->text('old_values')->nullable(); // JSON data lama
            $table->text('new_values')->nullable(); // JSON data baru
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
