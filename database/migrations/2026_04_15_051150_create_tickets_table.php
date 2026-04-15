<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tabel tickets
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('reporter_name');
            $table->string('reporter_email');
            $table->string('faculty')->nullable();
            $table->string('study_program')->nullable();
            $table->string('identification_number');
            $table->string('title');
            $table->text('description');
            $table->string('attachment')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'closed'])->default('pending');
            $table->timestamps();
        });
        
        // Tabel ticket_replies
        Schema::create('ticket_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('message');
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_replies');
        Schema::dropIfExists('tickets');
    }
};