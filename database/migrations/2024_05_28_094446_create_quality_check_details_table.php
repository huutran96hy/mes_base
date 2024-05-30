<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quality_check_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('check_id')->constrained('quality_checks')->onDelete('cascade');
            $table->string('quality_criteria')->index();
            $table->decimal('measurement', 10, 2);
            $table->string('result')->index();
            $table->string('unit');
            $table->decimal('standard_value', 10, 2);
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->index('check_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quality_check_details');
    }
};
