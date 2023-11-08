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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('proTitle');
            $table->text('description');
            $table->enum('status',['open','in-progress','closed'])->default("open")->nullable();
            $table->enum('skills',['نجار','سباك','نقاش','محارة','حداد','بناء','مساعد صنايعي','عامل حر']);
            $table->integer('budget');
            $table->integer("duration");
            $table->string('image')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('location_id')->constrained('locations');
            $table->timestamps();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
