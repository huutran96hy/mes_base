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
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_lot_id')->nullable()->constrained('lots')->onDelete('cascade');
            $table->string('lot_number')->index();
            $table->dateTime('production_date')->index();
            $table->dateTime('expiry_date')->nullable()->index();
            $table->decimal('quantity', 10, 2);
            $table->string('status')->index();
            $table->timestamps();
            
            $table->index('batch_id');
            $table->index('parent_lot_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lots');
    }
};
