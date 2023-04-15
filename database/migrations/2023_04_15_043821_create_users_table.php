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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->longText('address');
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->longText('photos');
            $table->string('creditcard_type',100);
            $table->string('creditcard_number',100);
            $table->string('creditcard_name',100);
            $table->string('creditcard_expired',100);
            $table->string('creditcard_cvv',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
