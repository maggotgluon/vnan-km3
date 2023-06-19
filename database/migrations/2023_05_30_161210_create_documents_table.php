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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('doc_type');
            $table->string('doc_code'); // XX-XXX-000
            $table->integer('doc_ver')->default('0'); // Rev
            $table->string('doc_name_th');
            $table->string('doc_name_en');
            $table->date('effective');
            $table->integer('ages');
            $table->string('referance_req_code');

            $table->integer('status');
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
        Schema::dropIfExists('documents');
    }
};
