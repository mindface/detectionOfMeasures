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
        Schema::create('group_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('make_user_id');
            $table->string('title');
            $table->text('detail');
            $table->json('count_user_ids');
            $table->json('count_task_ids');
            $table->string('group_id')->unique();
            $table->timestamps();

            $table->foreign('make_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_categories');
    }
};
