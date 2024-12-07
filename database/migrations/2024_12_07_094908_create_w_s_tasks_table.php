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
        Schema::create('ws_tasks', function (Blueprint $table) {
            $table->id('id_task');
            $table->string('nama_task');
            $table->string('label');
            $table->text('deskripsi')->nullable();
            $table->date('due_date');
            $table->enum('status', ['Not Started', 'In Progress', 'Done']);
            $table->enum('level_prioritas', ['Low', 'Medium', 'High']);
            $table->timestamps();
            $table->unsignedBigInteger('ws_id');
            $table->foreign('ws_id')->references('id_projek')->on('workspaces');
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('w_s_tasks');
    }
};
