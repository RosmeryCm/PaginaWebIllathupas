<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('activities', function (Blueprint $table) {
            $table->id(); $table->string('title',150); $table->text('description');
            $table->enum('dimension',['descomposicion','patrones','abstraccion','algoritmico']);
            $table->text('instructions'); $table->boolean('published')->default(false); $table->timestamps();
        });
        Schema::create('questions', function (Blueprint $table) {
            $table->id(); $table->foreignId('activity_id')->constrained()->cascadeOnDelete();
            $table->text('statement'); $table->json('options'); $table->unsignedTinyInteger('correct_option');
            $table->string('feedback_correct')->default('¡Excelente trabajo!');
            $table->string('feedback_incorrect')->default('Revisa el concepto e inténtalo nuevamente.');
            $table->timestamps();
        });
        Schema::create('responses', function (Blueprint $table) {
            $table->id(); $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('activity_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('selected_option'); $table->boolean('is_correct'); $table->timestamps();
        });
        Schema::create('results', function (Blueprint $table) {
            $table->id(); $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('activity_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('score'); $table->unsignedInteger('total_questions');
            $table->decimal('percentage',5,2); $table->timestamp('completed_at'); $table->timestamps();
            $table->index(['user_id','activity_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('results'); Schema::dropIfExists('responses');
        Schema::dropIfExists('questions'); Schema::dropIfExists('activities');
    }
};
