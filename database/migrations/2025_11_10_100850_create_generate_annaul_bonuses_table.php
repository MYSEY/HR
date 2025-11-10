<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2025_11_10_100850_create_generate_annaul_bonuses_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generate_annaul_bonuses', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->integer('performance_id');
            $table->string('status')->nullable();
            $table->decimal('annaul_bonus',50,2)->default(0);
            $table->string('increasement_of_year');
            $table->integer('percentage');
            $table->bigInteger('approved_by')->unsigned()->nullable();
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
        Schema::dropIfExists('generate_annaul_bonuses');
    }
};
