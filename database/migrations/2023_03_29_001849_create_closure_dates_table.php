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
        Schema::create('closure_dates', function (Blueprint $table) {
            $table->id();
            $table->integer('academic_year')->unique();
            $table->date('post_end_date');
            $table->date('comment_end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('closure_dates');
    }
};
