<?php

use App\Models\Role;
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
        Schema::create('permisions', function (Blueprint $table) {
            $table->id();
            $table->string('permission_name')->nullable();
            $table->string('read')->nullable();
            $table->string('write')->nullable();
            $table->string('create')->nullable();
            $table->string('delete')->nullable();
            $table->string('import')->nullable();
            $table->string('export')->nullable();
            $table->timestamps();
        });

        DB::table('permisions')->insert([
            ['permission_name'=>'Holidays','read'=>'Y','write'=>'Y','create'=>'Y','delete'=>'Y','import'=>'Y','export'=>'N'],
            ['permission_name'=>'Leaves','read'=>'Y','write'=>'Y','create'=>'Y','delete'=>'N','import'=>'N','export'=>'N'],
            ['permission_name'=>'Clients','read'=>'Y','write'=>'Y','create'=>'Y','delete'=>'N','import'=>'N','export'=>'N'],
            ['permission_name'=>'Projects','read'=>'Y','write'=>'N','create'=>'Y','delete'=>'N','import'=>'N','export'=>'N'],
            ['permission_name'=>'Tasks','read'=>'Y','write'=>'Y','create'=>'Y','delete'=>'Y','import'=>'N','export'=>'N'],
            ['permission_name'=>'Chats','read'=>'Y','write'=>'Y','create'=>'Y','delete'=>'Y','import'=>'N','export'=>'N'],
            ['permission_name'=>'Assets','read'=>'Y','write'=>'Y','create'=>'Y','delete'=>'Y','import'=>'N','export'=>'N'],
            ['permission_name'=>'Timing Sheets','read'=>'Y','write'=>'Y','create'=>'Y','delete'=>'Y','import'=>'N','export'=>'N'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permisions');
    }
};
