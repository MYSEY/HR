<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->timestamps();
        });
        DB::table('roles')->insert(
        [
            ['name' => 'Administrator'],
            ['name' => 'CEO'],
            ['name' => 'Manager'],
            ['name' => 'Team Leader'],
            ['name' => 'Accountant'],
            ['name' => 'Web Developer'],
            ['name' => 'Web Designer'],
            ['name' => 'HR'],
            ['name' => 'UI/UX Developer'],
            ['name' => 'SEO Analyst'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
