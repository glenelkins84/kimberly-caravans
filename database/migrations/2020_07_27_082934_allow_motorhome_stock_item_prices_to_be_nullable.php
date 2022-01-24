<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AllowMotorhomeStockItemPricesToBeNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('motorhome_stock_items', function (Blueprint $table) {
            $table->unsignedDecimal('recommended_price', 8, 2)->nullable()->change();
            $table->unsignedDecimal('price', 8, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('motorhome_stock_items', function (Blueprint $table) {
            $table->unsignedDecimal('recommended_price', 8, 2)->nullable(false)->change();
            $table->unsignedDecimal('price', 8, 2)->nullable(false)->change();
        });
    }
}
