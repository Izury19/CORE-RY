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
    Schema::table('billing_invoices', function (Blueprint $table) {
        $table->string('status')->default('pending')->after('total_amount');
    });
}

public function down()
{
    Schema::table('billing_invoices', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};
