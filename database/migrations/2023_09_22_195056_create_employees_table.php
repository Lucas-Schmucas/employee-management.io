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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('username');
            $table->string('prefix');
            $table->string('firstname');
            $table->string('middle_initial');
            $table->string('lastname');
            $table->string('gender');
            $table->string('email');
            $table->date('date_of_birth');
            $table->time('time_of_birth');
            $table->date('date_of_joining');
            $table->string('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
