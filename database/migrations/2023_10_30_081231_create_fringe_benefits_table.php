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
        Schema::create('fringe_benefits', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->decimal('amount_usd')->nullable();
            $table->decimal('amount_riel')->nullable();
            $table->date('request_date')->nullable();
            $table->date('paid_date')->nullable();
            $table->string('remark')->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
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
        Schema::dropIfExists('fringe_benefits');
    }
};
