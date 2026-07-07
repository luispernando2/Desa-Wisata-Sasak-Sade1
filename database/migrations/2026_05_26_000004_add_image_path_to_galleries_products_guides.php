<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('image_url');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('image_url');
        });

        Schema::table('tour_guides', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });

        Schema::table('tour_guides', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
};
