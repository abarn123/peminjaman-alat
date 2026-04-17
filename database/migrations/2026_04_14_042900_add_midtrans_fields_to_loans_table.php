<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('loans', function (Blueprint $table) {
        $table->string('midtrans_order_id')->nullable()->after('payment_proof_image_path');
        $table->enum('midtrans_status', ['pending', 'settlement', 'cancel', 'expire', 'deny'])->nullable()->after('midtrans_order_id');
        $table->json('midtrans_response')->nullable()->after('midtrans_status');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('loans', function (Blueprint $table) {
        $table->dropColumn(['midtrans_order_id', 'midtrans_status', 'midtrans_response']);
    });
}
};
