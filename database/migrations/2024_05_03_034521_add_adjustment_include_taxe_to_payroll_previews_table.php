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
            $table->decimal('adjustment_include_taxe')->after('other_benefits');
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
            $table->dropColumn('adjustment_include_taxe');
        });
    }
};
