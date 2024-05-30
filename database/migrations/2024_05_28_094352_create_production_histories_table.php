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
        Schema::create('production_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('production_orders')->onDelete('cascade');
            $table->foreignId('batch_id')->constrained('batches')->onDelete('cascade');
            $table->foreignId('lot_id')->constrained('lots')->onDelete('cascade');
            $table->foreignId('step_id')->constrained('process_steps')->onDelete('cascade');
            $table->foreignId('process_id')->constrained('processes')->onDelete('cascade');
            $table->dateTime('start_time')->index();
            $table->dateTime('end_time')->index();
            $table->decimal('quantity_completed', 10, 2);
            $table->decimal('quantity_NG', 10, 2);
            $table->string('status')->index();
            $table->foreignId('operator_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipment_id')->constrained()->onDelete('cascade');
            $table->decimal('material_used', 10, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->index('order_id');
            $table->index('batch_id');
            $table->index('lot_id');
            $table->index('step_id');
            $table->index('process_id');
            $table->index('operator_id');
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
        Schema::dropIfExists('production_histories');
    }
};
