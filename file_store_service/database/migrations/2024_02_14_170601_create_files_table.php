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
        /**
         * Create the 'files' table with necessary columns.
         */
        Schema::create('files', function (Blueprint $table) {
            // Unique identifier for each file
            $table->id();

            // Optional name for the file
            $table->string('name')->nullable();

            // Original name of the file
            $table->string('original_name');

            // File extension (e.g., 'pdf', 'docx')
            $table->string('extension');

            // File size in kilobytes (KB)
            $table->double('size');

            // Timestamps for record creation and modification
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /**
         * Drop the 'files' table if it exists.
         */
        Schema::dropIfExists('files');
    }
};
