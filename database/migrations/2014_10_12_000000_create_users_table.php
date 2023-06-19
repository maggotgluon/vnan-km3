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
            $table->string('staff_id')->unique(); //VNxxx
            $table->string('name');

            $table->string('department')->nullable(); //department name
            $table->string('department_head')->nullable(); //hod name list
            $table->string('position')->nullable(); //department name
            $table->string('user_level')->nullable(); // staff,super,assi,manager,director,MD
            $table->boolean('status')->default(true); // 1 current , 0 disible

            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
