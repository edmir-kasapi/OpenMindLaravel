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
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->foreignId('store_id')
                ->nullable()
                ->after('tokenable_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->index(['store_id', 'tokenable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->dropIndex(['store_id', 'tokenable_id']);
            $table->dropConstrainedForeignId('store_id');
        });
    }
};
