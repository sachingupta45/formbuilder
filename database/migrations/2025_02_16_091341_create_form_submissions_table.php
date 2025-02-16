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
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')
                  ->constrained('form_data') // Ensures form_id references the form_datas table
                  ->onDelete('cascade')        // Deletes related submissions when the form is deleted
                  ->onUpdate('cascade');       // Updates the foreign key if the form ID changes
            $table->string('token')->unique();
            $table->json('form_data');        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};
