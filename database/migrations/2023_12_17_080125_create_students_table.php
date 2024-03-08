<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('studentID', 8);
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email');
            $table->string('major');
            $table->string('section');
            $table->integer('workType')->nullable();; //On Site -1, Work from Home-2, Hybrid-3
            $table->string('jobTitle')->nullable();
            $table->json('suggestedCompany')->nullable();
            $table->json('matchedCompany')->nullable();
            $table->unsignedBigInteger('hiredCompany')->nullable();
            $table->json('position')->nullable();
            $table->string('supervisor')->nullable();
            $table->integer('status'); //active -1, drop-2, complete-3
            $table->integer('neededHours')->default(600);
            $table->foreign('hiredCompany')->references('id')->on('companies')->onDelete('set null')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
