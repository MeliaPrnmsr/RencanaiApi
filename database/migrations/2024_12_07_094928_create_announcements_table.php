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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id('id_announcement');
            $table->text('announcement');
            $table->unsignedBigInteger('ws_id');
            $table->foreign('ws_id')->references('id_projek')->on('workspaces');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id_user')->on('users');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
