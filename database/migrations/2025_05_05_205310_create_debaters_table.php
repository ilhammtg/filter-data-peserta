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
        Schema::create('debaters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained();
            $table->enum('position', ['debater_1', 'debater_2']);
            $table->string('name');
            $table->string('npm');
            $table->string('study_program');
            $table->string('gender');
            $table->string('phone');
            $table->text('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debaters');
    }
};
