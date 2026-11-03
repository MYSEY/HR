<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2026_10_27_162331_create_fn_special_reviews_table.php
     * 
     * Run the migration with docker
     * docker exec -it HRMS php artisan migrate --path=database/migrations/2026_10_27_162331_create_fn_special_reviews_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('fn_special_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id')->index();
            $table->unsignedBigInteger('branch_id')->index();
            $table->json('position_id');
            $table->unsignedTinyInteger('review');
            $table->date('from_date');
            $table->date('to_date');
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('fn_special_reviews');
    }
};
