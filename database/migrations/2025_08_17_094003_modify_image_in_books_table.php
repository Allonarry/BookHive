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
        Schema::table('books', function (Blueprint $table) {
            // Check if column exists first
            if (Schema::hasColumn('books', 'image')) {
                // Modify existing column
                $table->string('image')->nullable()->change();
            } else {
                // Create new column if it doesn't exist
                $table->string('image')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // For safety, check if column exists before trying to modify
            if (Schema::hasColumn('books', 'image')) {
                // Revert back to previous state if needed
                // Note: You can't truly "undo" a modify, so this depends on your needs
                $table->string('image')->nullable(false)->change();
                // OR if you want to completely remove:
                // $table->dropColumn('image');
            }
        });
    }
};