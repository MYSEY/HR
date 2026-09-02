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
        Schema::table('payroll_previews', function (Blueprint $table) {
            $table->decimal('other_benefits',50,2)->after('annual_incentive_bonus')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_previews', function (Blueprint $table) {
            $table->dropColumn('other_benefits');
        });
    }
};
