<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan migrate:refresh --path=database/migrations/2025_03_31_083848_create_fn_detail_locations_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('fn_detail_locations', function (Blueprint $table) {
            $table->id();
            $table->integer('expense_request_id');
            $table->decimal('amount_usd',50,2)->default(0);
            $table->decimal('amount_riel',50,2)->default(0);
            $table->integer('location_id');
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
        Schema::dropIfExists('fn_detail_locations');
    }
};
