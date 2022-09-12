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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('creator_email')->nullable();
            $table->unsignedBigInteger('coupon_type');
            $table->foreign('coupon_type')
                ->references('id')
                ->on('coupon_types')
                ->onDelete('cascade');
            $table->unsignedBigInteger('coupon_subtype');
            $table->foreign('coupon_subtype')
                ->references('id')
                ->on('coupon_subtypes')
                ->onDelete('cascade');
            $table->string('code');
            $table->string('value')->nullable();
            $table->integer('limit')->nullable();
            $table->string('status');
            $table->integer('used_times')->nullable();
            $table->date('valid_until')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_patterns');
    }
};
