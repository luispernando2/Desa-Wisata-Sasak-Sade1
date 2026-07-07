<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('package_tours', function (Blueprint $table) {
            if (!Schema::hasColumn('package_tours', 'tour_guide_id')) {
                $table->foreignId('tour_guide_id')->nullable()->constrained('tour_guides')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('package_tours', function (Blueprint $table) {
            if (Schema::hasColumn('package_tours', 'tour_guide_id')) {
                $table->dropForeign(['tour_guide_id']);
                $table->dropColumn('tour_guide_id');
            }
        });
    }
};

