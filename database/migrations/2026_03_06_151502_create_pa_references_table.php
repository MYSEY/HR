<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2026_03_06_151502_create_pa_references_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('pa_references', function (Blueprint $table) {
            $table->id();
            $table->integer('performance_id');
            $table->string('title_id');
            $table->string('purpose_id');
            $table->string('detail_id');
            $table->string('reference');
            $table->bigInteger('created_by')->unsigned()->nullable();
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
        Schema::dropIfExists('pa_references');
    }
};
