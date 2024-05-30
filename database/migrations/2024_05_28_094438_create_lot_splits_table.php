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
        Schema::create('lot_splits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('original_lot_id')->constrained('lots')->onDelete('cascade');
            $table->foreignId('new_lot_id')->constrained('lots')->onDelete('cascade');
            $table->decimal('split_quantity', 10, 2);
            $table->dateTime('split_date')->index();
            $table->timestamps();
            
            $table->index('original_lot_id');
            $table->index('new_lot_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lot_splits');
    }
};
