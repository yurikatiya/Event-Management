<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('galleries', 'status')) {
            Schema::table('galleries', function (Blueprint $table): void {
                $table->enum('status', ['draft', 'published'])->default('draft');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('galleries', 'status')) {
            Schema::table('galleries', function (Blueprint $table): void {
                $table->dropColumn('status');
            });
        }
    }
};
