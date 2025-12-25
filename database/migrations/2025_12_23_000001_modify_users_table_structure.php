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
            // Rename id to id_user if it doesn't exist
            if (!Schema::hasColumn('users', 'id_user')) {
                $table->renameColumn('id', 'id_user');
            }
            
            // Add username if it doesn't exist
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('id_user');
            }
            
            // Add role if it doesn't exist
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['superadmin', 'admin', 'teknisi'])->default('teknisi')->after('email');
            }

            // Drop name if it exists (since we use username)
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Reverse actions
             if (!Schema::hasColumn('users', 'id')) {
                $table->renameColumn('id_user', 'id');
            }
             if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
             if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->after('id');
            }
        });
    }
};
