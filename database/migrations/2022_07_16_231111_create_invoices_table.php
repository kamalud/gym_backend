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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('member_id',20);
            $table->decimal('amount');
            $table->tinyInteger('fee_type');
            $table->tinyInteger('pament_type');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('create_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('member_id')->references('member_id')->on('membars');
            $table->foreign('create_by')->references('id')->on('users');
        });
    }

    /**
     * 

     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
