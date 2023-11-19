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
        Schema::create('studyitems', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('parentpath');
            $table->string('name')->nullable();
            $table->integer('type');
            $table->string('studyday')->nullable();
            $table->integer('studytype')->nullable();
            $table->integer('studytime')->nullable();
            $table->integer('additionalstudytime')->nullable();
            $table->integer('achievement')->nullable();
            $table->string('studymemo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studyitems');
    }
};
