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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('phone')->unique();
            $table->string('parent_phone');
            $table->enum('gender',['ذكر','انثي']);
            $table->enum('category', ['admin', 'technical', 'student', 'parent', 'trainer'])->default('student');

            $table->unsignedBigInteger('grade_id')->nullable();
            $table->foreign('grade_id')->references('id')->on('grades')
            ->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->unsignedBigInteger('governorate_id')->nullable();
            $table->foreign('governorate_id')->references('id')->on('governorates')
            ->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->enum('type',['center','online']);
            $table->timestamp('last_login');
            $table->integer('wallet')->default(0);
            $table->boolean('is_loggin')->default(0);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
