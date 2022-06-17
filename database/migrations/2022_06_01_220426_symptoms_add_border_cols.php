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
        Schema::table('symptoms', function (Blueprint $table) {
			$table->integer('minBorder')->default(0);
            $table->integer('maxBorder')->default(100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	   Schema::table('symptoms', function (Blueprint $table) {
			$table->dropColumn('minBorder');
            $table->dropColumn('maxBorder');
        });
    }
};
