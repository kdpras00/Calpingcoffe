<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->string('secure_token', 64)->unique()->nullable()->after('qr_code');
            $table->index('secure_token');
        });

        // Generate secure tokens for existing tables
        DB::table('tables')->get()->each(function ($table) {
            $token = hash('sha256', Str::random(40) . $table->id . $table->number . now());
            $secureUrl = url('/menu?token=' . $token);
            
            DB::table('tables')
                ->where('id', $table->id)
                ->update([
                    'secure_token' => $token,
                    'qr_code' => $secureUrl
                ]);
        });

        // Make secure_token required after populating existing records
        Schema::table('tables', function (Blueprint $table) {
            $table->string('secure_token', 64)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->dropIndex(['secure_token']);
            $table->dropColumn('secure_token');
        });
    }
};
