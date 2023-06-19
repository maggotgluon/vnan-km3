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
        Schema::create('training_request_infos', function (Blueprint $table) {
            $table->id();
            $table->string('request_req_code');
            $table->json('meta_value')->nullable();
            $table->timestamps();

            $table->foreign('request_req_code')->references('req_code')->on('training_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_request_infos');
    }
};
