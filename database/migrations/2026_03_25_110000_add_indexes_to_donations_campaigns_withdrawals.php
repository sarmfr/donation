<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->index('status');
            $table->index('campaign_id'); // already has FK but explicit index helps query planner
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['campaign_id']);
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
    }
};
