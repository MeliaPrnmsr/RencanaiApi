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
        Schema::create('personal_tasks', function (Blueprint $table) {
            $table->id('id_personal_task');
            $table->string('nama_task');
            $table->text('deskripsi')->nullable();
            $table->date('due_date');
            $table->enum('status', ['Not Started', 'In Progress', 'Done']);
            $table->enum('level_prioritas', ['Low', 'Medium', 'High']);
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_tasks');
    }
};
