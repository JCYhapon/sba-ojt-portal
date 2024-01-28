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
        Schema::create('journals', function (Blueprint $table) {
            $table->id('journalID');
            $table->date('coverage_start_date'); // Start of the week reflection coverage
            $table->date('coverage_end_date'); // End of the week reflection
            $table->foreignId('studentID')->constrained('students');
            $table->integer('journalNumber');
            $table->text('reflection');
            $table->integer('hoursRendered');
            $table->integer('status')->default(1);
            $table->string('studentSignature')->nullable();
            $table->string('supervisorSignature')->nullable();
            $table->integer('grade')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
