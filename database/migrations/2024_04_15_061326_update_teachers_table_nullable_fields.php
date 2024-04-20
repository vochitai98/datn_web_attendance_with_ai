<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('phone')->nullable()->change();
            $table->date('dayofbirth')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('avt')->nullable()->change();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
