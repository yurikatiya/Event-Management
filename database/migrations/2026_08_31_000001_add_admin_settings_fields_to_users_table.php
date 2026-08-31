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
        Schema::table('users', function (Blueprint $table) {
            $table->string('company_name')->nullable()->after('role');
            $table->string('company_email')->nullable()->after('company_name');
            $table->string('company_phone')->nullable()->after('company_email');
            $table->string('company_address')->nullable()->after('company_phone');
            $table->text('company_description')->nullable()->after('company_address');
            $table->boolean('admin_notifications_enabled')->default(true)->after('company_description');
            $table->boolean('dark_mode')->default(false)->after('admin_notifications_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'company_name',
                'company_email',
                'company_phone',
                'company_address',
                'company_description',
                'admin_notifications_enabled',
                'dark_mode',
            ]);
        });
    }
};
