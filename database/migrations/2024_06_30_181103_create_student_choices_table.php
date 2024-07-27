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
        Schema::create('student_choices', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_true')->default(0);

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')
            ->onUpdate('CASCADE')->onDelete('SET NULL');
            
            $table->unsignedBigInteger('choice_id')->nullable();
            $table->foreign('choice_id')->references('id')->on('choices')
            ->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_choices');
    }
};
