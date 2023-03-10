<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsOnCommodities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commodities', function (Blueprint $table) {
            $table->float('horizontal_load')->default(1500)->comment('水平最大荷重');
            $table->float('vertical_load')->default(1500)->comment('壁掛最大荷重');
            $table->float('travel')->default(1500)->comment('行程(雙滑軌)');

            $table->decimal('resolution', 9, 4)->change();

            // $table->dropUnique('Specification');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commodities', function (Blueprint $table) {
            $table->dropColumn(['horizontal_load', 'vertical_load', 'travel']);
            $table->float('resolution')->change();
            // $table->unique(['name', 'resolution', 'linear_ruler'], 'Specification');
        });
    }
}
