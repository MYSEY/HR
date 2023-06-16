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
        Schema::create('candidate_resumes', function (Blueprint $table) {
            $table->id();
            $table->string('name_kh');
            $table->string('name_en')->nullable();
            $table->string('gender')->nullable();
            $table->string('current_position')->nullable();
            $table->string('companey_name')->nullable();
            $table->string('position_applied')->nullable();
            $table->string('current_address')->nullable();
            $table->string('location_applied')->nullable();
            $table->date('received_date')->nullable();
            $table->string('recruitment_channel')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('status')->nullable();
            $table->longText('cv')->nullable();
            $table->dateTime('interviewed_date')->nullable();
            $table->string('committee_interview')->nullable();
            $table->string('interviewed_result')->nullable();
            $table->date('join_date')->nullable();
            $table->string('remark')->nullable();
            $table->boolean('short_list')->nullable();
            $table->boolean('joined_interview')->nullable();
            $table->date('contract_date')->nullable();
            $table->string('interviewed_channel')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
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
        Schema::dropIfExists('candidate_resumes');
    }
};
