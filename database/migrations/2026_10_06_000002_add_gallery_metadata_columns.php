<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table): void {
            if (! Schema::hasColumn('galleries', 'title')) {
                $table->string('title', 150)->nullable();
            }

            if (! Schema::hasColumn('galleries', 'description')) {
                $table->text('description')->nullable();
            }
        });
    }

    public function down(): void
    {
        // Keep reconciled gallery metadata columns to avoid dropping pre-existing data.
    }
};
