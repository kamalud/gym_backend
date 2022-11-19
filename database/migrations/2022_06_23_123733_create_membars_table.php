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
        Schema::create('membars', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('member_id',20)->unique();
            $table->string('name',50);
            $table->tinyInteger('gender');
            $table->string('mobile',11)->unique();
            $table->enum('blood_group',["A+","A-",":B+","B-","AB+","AB-","O+","O-"]);
            $table->string('photo',100);
            $table->text('address');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('card_no',15)->default(0000000000);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('lock')->default(0);
            $table->unsignedBigInteger('create_by')->nullable();
            $table->timestamps();

            $table->foreign('create_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('membars');
    }
};
