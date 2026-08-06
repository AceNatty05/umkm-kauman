<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('photo'); // Cloudinary URL - foto utama
            $table->string('owner_name'); // Nama pemilik
            $table->string('phone')->nullable(); // No WA UMKM
            $table->text('description');
            $table->string('location')->nullable(); // Link Google Maps
            $table->string('operating_hours')->nullable(); // Jam buka
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
