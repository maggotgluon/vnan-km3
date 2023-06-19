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
        Schema::create('training_requests', function (Blueprint $table) {
            $table->id();
            $table->string('req_code')->unique(); // Dar number

            $table->string('req_obj')->default('0')->nullable(); // register objection
            $table->string('req_title')->nullable(); // register objection
            $table->integer('req_status')->default('0'); // status 0 draft 1 pending 2 approved -1 reject

            $table->foreignId('user_id');

            $table->dateTime('req_dateReview')->nullable(); //approved date
            $table->string('user_review')->nullable(); // who approve
            $table->dateTime('req_dateApprove')->nullable(); //approved date
            $table->string('user_approve')->nullable(); // who approve
            $table->text('remark')->nullable(); // status 0 draft 1 pending 2 approved -1 reject
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
        Schema::dropIfExists('training_requests');
    }
};
