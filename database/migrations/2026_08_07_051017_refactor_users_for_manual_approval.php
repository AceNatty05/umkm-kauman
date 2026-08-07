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
        Schema::dropIfExists('otp_codes');

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('phone_verified', 'is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('is_active', 'phone_verified');
        });

        Schema::create('otp_codes', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->index();
            $table->string('code', 6);
            $table->string('type')->default('register'); // register, reset_password
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }
};
