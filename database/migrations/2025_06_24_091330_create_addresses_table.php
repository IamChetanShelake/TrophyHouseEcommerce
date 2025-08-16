<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
public function up()
{
    if (!Schema::hasTable('addresses')) {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('pincode');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->text('delivery_instructions')->nullable();
            $table->boolean('is_default')->default(0);
            $table->timestamps();
        });
    }
}


    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}