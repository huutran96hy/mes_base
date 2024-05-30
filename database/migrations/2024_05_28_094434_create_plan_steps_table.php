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
        Schema::create('plan_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('production_plans')->onDelete('cascade');
            $table->foreignId('step_id')->constrained('process_steps')->onDelete('cascade');
            $table->foreignId('equipment_id')->constrained()->onDelete('cascade');
            $table->dateTime('plan_start_time')->index();
            $table->dateTime('plan_end_time')->index();
            $table->decimal('planned_quantity', 10, 2);
            $table->timestamps();
            
            $table->index('plan_id');
            $table->index('step_id');
            $table->index('equipment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_steps');
    }
};
