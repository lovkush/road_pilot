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
            $table->integer('id', true);
            $table->string('f_name');
            $table->string('l_name');
            $table->string('email');
            $table->integer('phone');
            $table->string('addressLine1');
            $table->string('addressLine2');
            $table->string('landmark');
            $table->string('city');
            $table->string('state');
            $table->integer('pin');
            $table->point('coordinates');
            $table->text('image');
            $table->integer('isVerified')->default(0);
            $table->integer('userType');
            $table->timestamp('createdAt')->useCurrent();
            $table->text('cm_firebase_token');
            $table->string('ref_code', 20);
            $table->text('remember_token');
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
