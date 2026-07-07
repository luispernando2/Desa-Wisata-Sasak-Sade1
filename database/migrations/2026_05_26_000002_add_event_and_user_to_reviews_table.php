<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('event_id')->nullable()->constrained('events')->cascadeOnDelete()->after('id');
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete()->after('event_id');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['event_id', 'user_id']);
        });
    }
};
