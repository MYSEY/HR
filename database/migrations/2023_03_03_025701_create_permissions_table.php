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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->integer('table_id')->nullable();
            $table->integer('role_id');
            $table->integer('permission_type_id')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('parent_id');
            $table->string('name');
            $table->boolean('is_active')->nullable();
            $table->boolean('is_create')->nullable();
            $table->boolean('is_view')->nullable();
            $table->boolean('is_update')->nullable();
            $table->boolean('is_delete')->nullable();
            $table->boolean('is_cancel')->nullable();
            $table->boolean('is_accept')->nullable();
            $table->boolean('is_approve')->nullable();
            $table->boolean('is_print')->nullable();
            $table->boolean('is_import')->nullable();
            $table->boolean('is_export')->nullable();
            $table->boolean('is_access')->nullable();
            $table->boolean('is_view_report')->nullable();
            $table->boolean('is_operation')->nullable();
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
        Schema::dropIfExists('permissions');
    }
};
