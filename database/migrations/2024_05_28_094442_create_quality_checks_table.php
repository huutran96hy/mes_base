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
        Schema::create('quality_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lot_id')->constrained('lots')->onDelete('cascade');
            $table->foreignId('step_id')->constrained('process_steps')->onDelete('cascade');
            $table->string('check_type')->index();
            $table->dateTime('start_time')->index();
            $table->dateTime('end_time')->index();
            $table->string('result')->index();
            $table->string('inspector_id');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->index('lot_id');
            $table->index('step_id');
            $table->index('inspector_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quality_checks');
    }
};
