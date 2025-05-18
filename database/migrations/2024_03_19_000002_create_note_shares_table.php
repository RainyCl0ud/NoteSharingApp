<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('note_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('note_id')->constrained()->onDelete('cascade');
            $table->foreignId('shared_with_user_id')->constrained('users')->onDelete('cascade');
            $table->enum('permission', ['view', 'edit']);
            $table->timestamps();

            $table->unique(['note_id', 'shared_with_user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('note_shares');
    }
}; 