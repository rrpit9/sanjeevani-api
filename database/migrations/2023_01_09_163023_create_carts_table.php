<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('Referance of Customer')->index();
            $table->unsignedBigInteger('client_id')->nullable()->comment('Referance of Clients')->index();
            $table->unsignedBigInteger('business_id')->nullable()->comment('Referance of Business')->index();
            $table->nullableMorphs('itemable');
            $table->unsignedTinyInteger('status')->default(0)->index()->comment('INITIATED:0, PAYMENT_FAILED:1, PAYMENT_COMPLETE:2, FULFILLED:3, REFUND_INITIATED:4, PAYMENT_REFUNDED:5');
            $table->decimal('price',8,2)->default(0)->comment('Item MRP for Single Unit');
            $table->decimal('discount_amount',8,2)->default(0)->comment('Discount in Amount');
            $table->decimal('quantity',4,2)->default(1)->comment('Quantity Of the Item');
            $table->decimal('total_payable_amount', 8,2)->default(0)->comment('Total Amount Payable for this Cart');
            $table->unsignedBigInteger('master_order_id')->nullable()->comment('Master Order Id');
            $table->ipAddress('ip')->nullable();
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        Schema::create('master_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('client_id')->nullable()->comment('Referance of Clients')->index();
            $table->unsignedBigInteger('business_id')->nullable()->comment('Referance of Business')->index();
            $table->unsignedTinyInteger('status')->default(0)->index()->comment('INITIATED:0, PAYMENT_FAILED:1, PAYMENT_COMPLETE:2, FULFILLED:3, REFUND_INITIATED:4, PAYMENT_REFUNDED:5');
            $table->decimal('total_amount', 8,2)->default(0)->comment('Total Amount Payable for this Order');
            $table->decimal('by_wallet',8,2)->default(0)->comment('Amount Paid By Wallet');
            $table->decimal('by_online',8,2)->default(0)->comment('Amount Paid By Online');
            $table->string('gateway_order_id',100)->nullable()->comment('Gateway Order Id From Payment Table');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('fulfilled_at')->nullable();
            $table->longText('cart_ids')->nullable()->comment('Cart Ids Comma Separated');
            $table->ipAddress('ip')->nullable();
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        Schema::create('master_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->nullableMorphs('orderable');
            $table->unsignedTinyInteger('status')->index()->comment('INITIATED:0, PAYMENT_FAILED:1, PAYMENT_COMPLETE:2, FULFILLED:3, REFUND_INITIATED:4, PAYMENT_REFUNDED:5');
            $table->string('gateway_status')->nullable()->comment('The payment status returned by the gateway');
            $table->string('gateway')->comment('The payment gateway name');
            $table->string('payment_method')->nullable()->comment('The payment method name');
            $table->string('gateway_order_id')->nullable()->comment('The payment gateway/merchant order id');
            $table->string('gateway_payment_id')->nullable()->comment('The payment gateway payment id');
            $table->string('description')->comment('Short description about the payable item');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('currency', 5)->default('INR');
            $table->decimal('amount', 10)->comment('The final payment amount charged');
            $table->decimal('gateway_fee', 10)->nullable()->comment('Gateway fee including all the taxes and additional charges collected by payment gateway.');
            $table->decimal('gateway_gst_rate', 4)->nullable()->comment('GST rate charged by the payment gateway');
            $table->decimal('gateway_gst_amount', 10)->nullable()->comment('GST amount charged by the payment gateway');
            $table->string('error_message')->nullable();
            $table->longText('order_response')->nullable()->comment('The full gateway order api response data');
            $table->longText('payment_response')->nullable()->comment('The full gateway payment api response data');
            $table->ipAddress('ip')->nullable();
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
        Schema::dropIfExists('master_orders');
        Schema::dropIfExists('master_payments');
    }
}
