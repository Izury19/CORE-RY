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
    Schema::create('equipment', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('plate_number')->nullable();
        $table->enum('status', ['available', 'maintenance', 'in-use'])->default('available');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
