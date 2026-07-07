<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('reviews', 'package_id')) {
                $table->foreignId('package_id')->nullable()->constrained('package_tours')->nullOnDelete()->after('event_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            if (Schema::hasColumn('reviews', 'package_id')) {
                $table->dropConstrainedForeignId('package_id');
                $table->dropColumn('package_id');
            }
        });
    }
};

