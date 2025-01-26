<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->id('employee_id');
            $table->string('first_name', 255)->nullable(false);
            $table->string('last_name', 255)->nullable(false);
            $table->date('date_of_birth')->nullable(false);
            $table->string('gender', 10)->nullable(false);
            $table->date('hire_date')->nullable(false);
            $table->unsignedBigInteger('department_id')->nullable(false);
            $table->unsignedBigInteger('position_id')->nullable(false);
            $table->decimal('salary', 10, 2)->nullable(false);
            $table->string('driving_license_path')->nullable();
            $table->string('background_check_path')->nullable();
            $table->string('other_documents_path')->nullable();
            $table->string('photo_path')->nullable();
            $table->timestamps();

            $table->foreign('department_id')->references('department_id')->on('department')->onDelete('cascade');
            $table->foreign('position_id')->references('position_id')->on('position')->onDelete('cascade');

            $table->index('department_id');
            $table->index('position_id');
            $table->index(['first_name', 'last_name']);
            $table->index('hire_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
